<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends BaseController
{

    public function __construct()
    {
        $this->model = new Log();
        parent::__construct();

    }
}
