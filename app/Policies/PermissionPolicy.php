<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasAdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;
    use HasAdminRole;

    public function index(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-permission-list'));
    }

    public function edit(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-permission'));
    }

    public function create(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('create-permission'));
    }

    public function update(User $user)
    {
        return $user && $user->hasPermission('update-permission');
    }

    public function delete(User $user)
    {
        return $user && $user->hasPermission('delete-permission');
    }

    public function restore(User $user)
    {
        return $user && $user->hasPermission('restore-permission');
    }

    public function forceDelete(User $user)
    {
        return $user && $user->hasPermission('force-delete-permission');
    }
}
