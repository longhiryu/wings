<?php

namespace App\View\Composers;

use App\Models\Role;
use Illuminate\View\View;

class RoleComposer
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function compose(View $view)
    {
        $view->with('roles', $this->role::all());
    }
}
