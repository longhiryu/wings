<?php

namespace App\View\Composers;

use App\Models\Permission;
use Illuminate\View\View;

class PermissionComposer
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function compose(View $view)
    {
        $view->with('permissions', $this->permission::orderBy('id', 'DESC')->get());
    }
}
