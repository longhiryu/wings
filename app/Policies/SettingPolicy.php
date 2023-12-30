<?php

namespace App\Policies;

use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Setting();
        parent::__construct();   
    }
}
