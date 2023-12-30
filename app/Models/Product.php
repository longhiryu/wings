<?php

namespace App\Models;

use DB;
use Exception;
use App\Traits\HasImage;
use App\Traits\HasTranslated;
use App\Traits\Livewire\HasChannel;
use App\Traits\Livewire\HasCategory;
use App\Traits\Livewire\HasCustomer;
use App\Traits\Livewire\HasSupplier;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $price
 * @property string|null $special_price
 * @property string|null $special_price_start
 * @property string|null $special_price_end
 * @property string|null $selling_price
 * @property string|null $sku
 * @property int|null $qty
 * @property int $in_stock
 * @property int $viewed
 * @property int $is_active
 * @property string|null $new_from
 * @property string|null $new_to
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \App\Models\ProductTranslation|null $translated
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNewFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNewTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecialPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecialPriceEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecialPriceStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereViewed($value)
 * @mixin \Eloquent
 */
class Product extends BaseModel
{
    use HasChannel, HasTranslated, HasImage, HasCategory, HasSupplier, SoftDeletes, HasCustomer;

    protected $fillable = [
        'category_id',
        'file_id',
        'rating',
        'unit',
        'material',
        'supplier_id',
        'customer_id',
        'price',
        'sku',
        'special_price',
        'in_stock',
        'viewed',
        'is_active',
    ];
    protected $with = ['translated', 'categories', 'images'];

    public function __construct()
    {
        parent::__construct();
    }

    public function translatedModel()
    {
        return new ProductTranslation();
    }

    public function duplicateProduct($id)
    {
        DB::beginTransaction();

        try {
            $product = $this->find($id);
            $productTranslation = $product->translated;

            $new = $product->replicate();
            $new->sku = $product->sku . '_duplicated';
            $new->save();

            $newTranslation = $productTranslation->replicate();
            $newTranslation->product_id = $new->id;
            $newTranslation->save();

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;

            return false;
        }
    }
    
    

    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_products', 'product_id', 'project_id')
            ->withPivot(['product_name', 'product_unit', 'product_price', 'product_quantity', 'note'])
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id')
            ->withPivot(['product_name', 'product_unit', 'product_price', 'product_quantity', 'note'])
            ->withTimestamps();
    }

    public function stocks()
    {
        return $this->belongsToMany(Inventory::class, 'inventory_products', 'product_id', 'inventory_id')
            ->withPivot(['product_name', 'product_unit', 'import_price', 'selling_price', 'product_quantity', 'note'])
            ->withTimestamps();
    }

    public function checkBeforeDelete()
    {
        try {
            ! $this->projects->isEmpty() && throw new Exception('Sản phẩm đã được thêm vào dự án!');
            ! $this->orders->isEmpty() && throw new Exception('Sản phẩm đã được lên đơn hàng!');
            ! $this->stocks->isEmpty() && throw new Exception('Sản phẩm đã nhập kho!');

            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
            //throw $th;
        }
    }
}
