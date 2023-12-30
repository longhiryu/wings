<?php

namespace App\Policies;

use App\Models\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->model = new Article();
        parent::__construct();   
    }
}

