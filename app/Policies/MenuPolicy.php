<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasAdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;
    use HasAdminRole;

    public function index(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-menu-list'));
    }

    public function edit(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-menu'));
    }

    public function create(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('create-menu'));
    }

    public function update(User $user)
    {
        return $user && $user->hasPermission('update-menu');
    }

    public function delete(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('delete-menu'));
    }

    public function restore(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('restore-menu'));
    }

    public function forceDelete(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('force-delete-menu'));
    }
}
