<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct()
    {
        $this->model = new Category();
        parent::__construct();
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->all();

        return $this->insert_data($data, $category);
    }


}
