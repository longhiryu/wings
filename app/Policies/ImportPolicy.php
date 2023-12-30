<?php

namespace App\Policies;

use App\Models\Import;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImportPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Import();
        parent::__construct();   
    }
}
