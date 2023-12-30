<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\CreateProductRequest;

class ProductController extends BaseController
{
    protected $quotation_key;

    public function __construct()
    {
        $this->model = new Product();
        $this->quotation_key = Config::get('quotation.session_key');

        parent::__construct();
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();

        return $this->insert_data($data, $product);
    }
}
