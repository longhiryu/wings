<?php

namespace App\Policies;

use App\Models\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Tag();
        parent::__construct();   
    }
}
