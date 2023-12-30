<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductQuotation
 *
 * @property int $id
 * @property int $quotation_id
 * @property string|null $product_name
 * @property int|null $product_id
 * @property float|null $product_price
 * @property int|null $product_quantity
 * @property string|null $product_unit
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereProductQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereProductUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuotation whereQuotationId($value)
 * @mixin \Eloquent
 */
class ProductQuotation extends Model
{
    protected $fillable = ['quotation_id','product_name','product_price','product_id','product_quantity','product_unit'];

    protected $table = 'product_quotations';

    public $timestamps = false;
}
