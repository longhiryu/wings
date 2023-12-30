<?php

namespace App\Traits;

use App\Models\Channel;
use Illuminate\Support\Arr;

trait HasChannel
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasChannel()
    {
        static::saved(function ($entity) {
            $entity->channels()->sync(Arr::get(request()->all(), 'channels', []));
        });
    }

    public function channels()
    {
        return $this->morphToMany(Channel::class,'channelable');
    }
}
