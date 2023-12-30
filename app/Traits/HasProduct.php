<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Support\Arr;

trait HasProduct
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasProduct()
    {
        static::saved(function ($entity) {
            $entity->products()->sync(Arr::get(request()->all(), 'products', []));
        });
    }


    public function products()
    {
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_quantity','product_price','product_name');
    }
}
