<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasAdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogPolicy
{
    use HandlesAuthorization;
    use HasAdminRole;

    public function index(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-log-list'));
    }

    public function edit(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-log'));
    }

    public function create(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('create-log'));
    }

    public function update(User $user)
    {
        return $user && $user->hasPermission('update-log');
    }

    public function delete(User $user)
    {
        return $user && $user->hasPermission('delete-log');
    }

    public function restore(User $user)
    {
        return $user && $user->hasPermission('restore-log');
    }

    public function forceDelete(User $user)
    {
        return $user && $user->hasPermission('force-delete-log');
    }
}
