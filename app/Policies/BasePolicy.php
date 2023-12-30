<?php

namespace App\Policies;

use App\Models\User;
use App\Sys\SysCore;
use App\Models\Permission;
use Illuminate\Support\Str;

class BasePolicy
{
    public $sysCore;
    public $model;
    public $modelName;
    public $rights = [
        'index',
        'edit',
        'create',
        'update',
        'delete',
    ];

    public function __construct()
    {
        $this->sysCore = new SysCore();
        $this->modelName = class_basename($this->model);

        $this->checkPermissionExisted();
    }

    /**
     * Kiểm tra phân quyền tồn tại, nếu chưa thì tạo phân quyền
     * @return [type]
     */
    public function checkPermissionExisted()
    {
        foreach ($this->rights as $right) {
            $rightName = Str::slug($this->modelName . '-' . $right);
            Permission::firstOrCreate([
                'slug' => $rightName,
            ], [
                'name' => $this->sysCore->convetSlugToTitle($rightName),
                'slug' => $rightName,
                'is_active' => true,
                'type' => strtolower($this->modelName)
            ]);
        }
    }

    public function checkPermission($slug, $user)
    {
        $group = $user->group;
        $permission = $group->permissions()->where('slug', $slug)->first();

        return $permission ? true : false;
    }

    public function handlePermission($user, $permission)
    {
        $rightName = Str::slug($this->modelName . '-' . $permission);

        return $user->group->exclusive_access || $this->checkPermission($rightName, $user);
    }

    public function index(User $user)
    {
        return $this->handlePermission($user, 'index');
    }

    public function create(User $user)
    {
        return $this->handlePermission($user, 'create');
    }

    public function edit(User $user)
    {
        return $this->handlePermission($user, 'edit');
    }

    public function delete(User $user)
    {
        return $this->handlePermission($user, 'delete');
    }
}
