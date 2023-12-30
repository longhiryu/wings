<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends BaseController
{
    public function __construct()
    {
        $this->model = new MenuItem();

        parent::__construct();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->all();

        return $this->insert_data($data, $menuItem);
    }
}
