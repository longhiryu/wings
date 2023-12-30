<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPosts()
    {   
        $data = callAPI();

        dd(json_decode($data));
    }
}
