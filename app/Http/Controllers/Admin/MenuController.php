<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    public function __construct()
    {
        $this->model = new Menu();

        parent::__construct();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->all();

        return $this->insert_data($data, $menu);
    }
}
