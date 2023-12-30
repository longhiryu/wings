<?php

namespace App\Traits;

trait HasAdminRole
{
    public function checkAdminRole()
    {
        $roles = Auth()->user()->roles;
        // kiểm tra trong collection trả về có slug admin hay không
        return $roles->contains('slug', 'admin');
    }
}
