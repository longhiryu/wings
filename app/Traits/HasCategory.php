<?php

namespace App\Traits;

use App\Models\Category;
use Illuminate\Support\Arr;

trait HasCategory
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasCategory()
    {
        static::saved(function ($entity) {
            $entity->categories()->sync(Arr::get(request()->all(), 'categories', []));
        });
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }
}
