<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function permissions(){
        return $this->morphToMany(Permission::class,'permissionable');
    }
}
