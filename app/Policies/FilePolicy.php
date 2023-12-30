<?php

namespace App\Policies;

use App\Models\File;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new File();
        parent::__construct();   
    }
}
