<?php

namespace App\Policies;

use App\Models\InventoryProduct;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryProductPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new InventoryProduct();
        parent::__construct();   
    }
}
