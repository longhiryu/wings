<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\HasAdminRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;
    use HasAdminRole;

    public function index(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-role-list'));
    }

    public function view(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-role'));
    }

    public function create(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('create-role'));
    }

    public function edit(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('view-role'));
    }

    public function update(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('update-role'));
    }

    public function delete(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('delete-role'));
    }

    public function restore(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('restore-role'));
    }

    public function forceDelete(User $user)
    {
        return $this->checkAdminRole() || ($user && $user->hasPermission('force-delete-role'));
    }
}
