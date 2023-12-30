<?php

namespace App\Models;

use App\Traits\TraitProductQuotation;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Quotation
 *
 * @property int $id
 * @property string $name
 * @property int $customer_id
 * @property int $user_id
 * @property float $sub_total
 * @property int $tax_rate
 * @property float $total
 * @property string $payment_condition
 * @property string $note
 * @property string|null $deadline
 * @property int $contract
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Order|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductQuotation[] $product_quotation
 * @property-read int|null $product_quotation_count
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation wherePaymentCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereUserId($value)
 * @mixin \Eloquent
 * @property int $type 0: là đơn hàng mua vào, 1 là đơn hàng bán ra
 * @property string $service
 * @property string|null $sku
 * @property int|null $company_id
 * @property-read \App\Models\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Quotation whereType($value)
 */
class Quotation extends Model
{
    use TraitProductQuotation;

    protected $fillable = ['name', 'customer_id', 'user_id', 'company_id', 'sub_total', 'tax_rate', 'total', 'payment_condition', 'note', 'deadline', 'contract', 'type', 'service'];

    protected $with = ['product_quotation', 'customer'];

    /**
     * Them trang thai cua bang bao gia
    */
    public function product_quotation()
    {
        return $this->hasMany(ProductQuotation::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
