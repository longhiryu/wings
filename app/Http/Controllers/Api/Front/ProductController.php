<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Product;
use App\Models\ProductTranslation;
use App\Http\Resources\Api\Front\ProductResource;
use App\Http\Resources\Api\Front\ProductCollection;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->model = new Product();
        $this->collection = ProductCollection::class;
        $this->resource = ProductResource::class;
        $this->translation = new ProductTranslation();

        parent::__construct();
    }
}
