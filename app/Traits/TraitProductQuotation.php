<?php

namespace App\Traits;

use App\Models\ProductQuotation;

trait TraitProductQuotation
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootTraitProductQuotation()
    {
        static::saved(function ($entity) {
            $data = session('pro-list-array');
            if ($data) {
                foreach ($data as &$value) {
                    $value['quotation_id'] = $entity->id;
                }
                foreach ($data as $item) {
                    ProductQuotation::create($item);
                }
            }
            session()->forget('pro-list-array');
        });
    }
}
