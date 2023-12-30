<?php
namespace App\Traits;

use App\Models\Role;

trait HasPermission
{
    protected $permissionList = null;

    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasPermission()
    {
        if(request('roles') != null && !empty(request('roles'))){
            static::saved(function ($model) {
            $model->roles()->sync(request('roles'));
        });
        }
        
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }

        return false;
    }

    public function hasPermission($permission = null)
    {
        if (is_null($permission)) {
            return $this->getPermissions()->count() > 0;
        }

        if (is_string($permission)) {
            return $this->getPermissions()->contains('slug', $permission);
        }

        return false;
    }

    private function getPermissions()
    {
        // $this la user
        $role = $this->roles->first();
        if ($role) {
            if (! $role->relationLoaded('permissions')) {
                $this->roles->load('permissions');
            }

            $this->permissionList = $this->roles->pluck('permissions')->flatten();
        }

        return $this->permissionList ?? collect();
    }
}
