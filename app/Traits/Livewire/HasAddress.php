<?php

namespace App\Traits\Livewire;

use App\Models\Address;
use Session;

trait HasAddress
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    // protected static function bootHasAddress()
    // {
    //     if (Session::get('channel') != null) {
    //         $channel = Session::get('channel');
    //         static::saved(function ($entity) use($channel) {
    //             $entity->channels()->sync([$channel->id]);
    //         });
    //     }
    // }

    public function addresses()
    {
        return $this->morphToMany(Address::class,'addressable');
    }
}
