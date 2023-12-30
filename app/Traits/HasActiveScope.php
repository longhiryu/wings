<?php

namespace App\Traits;

trait HasActiveScope
{
    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query, int $status = 1)
    {
        return $query->where('acctive', $status);
    }
}
