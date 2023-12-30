<?php

namespace App\Policies;

use App\Models\SupplierOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierOrderPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new SupplierOrder();
        parent::__construct();   
    }
}
