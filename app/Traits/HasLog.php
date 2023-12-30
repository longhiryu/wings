<?php

namespace App\Traits;

use App\Models\Log;

trait HasLog
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasLog()
    {
        $log = new Log();

        static::created(function ($entity) use ($log) {
            $log->log('created', $entity);
        });

        static::updated(function ($entity) use ($log) {
            $log->log('updated', $entity);
        });

        self::deleted(function ($entity) use ($log) {
            $log->log('deleted', $entity);
        });
    }
}
