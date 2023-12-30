<?php

namespace App\Sys;

class SysView
{
    public const _PAGE_INDEX = 'index';
    public const _PAGE_FORM = '_form';
    public const _LIVEWIRE_ADMIN_VIEW = 'livewire.admin';
    public const _LIVEWIRE_ADMIN_MASTER_VIEW = 'star-admin.master';
    public const _LIVEWIRE_ADMIN_SECTION = 'content';

    protected $base_path = 'sys';

    public function isActive($status)
    {
    }

    public function livewireAdminIndexView($type)
    {
        return $this::_LIVEWIRE_ADMIN_VIEW . '.' . $type . '.index';
    }
}
