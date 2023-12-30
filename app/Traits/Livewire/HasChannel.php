<?php

namespace App\Traits\Livewire;

use Session;
use App\Models\Channel;

trait HasChannel
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasChannel()
    {
        if (Session::get('channel') != null) {
            $channel = Session::get('channel');
            static::saved(function ($entity) use ($channel) {
                $entity->channels()->sync([$channel->id]);
            });
        }
    }

    public function channels()
    {
        return $this->morphToMany(Channel::class, 'channelable');
    }
}
