<?php

namespace App\Policies;

use App\Models\Label;
use Illuminate\Auth\Access\HandlesAuthorization;

class LabelPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Label();
        parent::__construct();   
    }
}
