<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Arr;

trait HasFile
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasFile()
    {
        static::saved(function ($entity) {
            $files = Arr::get(request()->all(), 'files', []);
            if (! empty($files)) {
                $entity->files()->sync($files);
            }
        });
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'filedable');
    }
}
