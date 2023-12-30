<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Arr;

trait HasImage
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasImage()
    {
        static::saved(function ($entity) {
            $images = Arr::get(request()->all(), 'images', []);
            if (! empty($images)) {
                foreach ($images as $value) {
                    $entity->images()->create(['path' => $value]);
                }
            }
        });
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }
}
