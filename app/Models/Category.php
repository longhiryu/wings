<?php

namespace App\Models;

use App\Traits\HasTranslated;
use App\Models\File;
use App\Traits\Livewire\HasChannel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $position
 * @property int $is_active
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read int|null $channels_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\CategoryTranslation|null $translated
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends BaseModel
{
    use HasChannel, HasTranslated;

    protected $fillable = ['parent_id', 'position', 'is_active', 'type', 'file_id'];
    protected $with = ['translated'];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'categorizable');
    }

    public static function getListSelectCategory()
    {
        $cates = Category::where('is_active', 1)->get();
        $categories = [];
        foreach ($cates as $key => $value) {
            $categories[$value->id] = $value->translate('name');
        }

        return $categories; // array id => name
    }

    public function translatedModel()
    {
        return new CategoryTranslation();
    }

    public function artciels(){
        return $this->hasMany(Article::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function file(){
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
