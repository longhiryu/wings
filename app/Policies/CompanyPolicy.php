<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy extends
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Company();
        parent::__construct();   
    }
}
