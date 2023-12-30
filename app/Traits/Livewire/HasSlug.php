<?php

namespace App\Traits\Livewire;

use Str;

trait HasSlug
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasSlug()
    {
        static::saved(function ($entity) {
            if ($entity->name) {
                $entity->update(['slug' => Str::slug($entity->name)]);
                return false;
            }
        });
    }
}
