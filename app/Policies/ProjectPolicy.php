<?php

namespace App\Policies;

use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Project();
        parent::__construct();   
    }
}
