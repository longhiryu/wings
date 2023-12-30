<?php

namespace App\Traits;

use App\Models\Tag;
use Illuminate\Support\Arr;

trait HasTag
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasTag()
    {
        static::saved(function ($entity) {
            $entity->tags()->sync(Arr::get(request()->all(), 'tags', []));
        });
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
