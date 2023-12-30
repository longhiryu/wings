<?php

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class UserComposer
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function compose(View $view)
    {
        $view->with('users', $this->user::all());
    }
}
