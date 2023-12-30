<?php

namespace App\Policies;

use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Product();
        parent::__construct();   
    }
}
