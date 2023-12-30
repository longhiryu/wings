<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Product;
use App\Http\Resources\Api\Admin\ProductResource;
use App\Http\Resources\Api\Admin\ProductCollection;
use App\Http\Resources\Api\Admin\ProductDetailResource;
use App\Models\ProductTranslation;
use GuzzleHttp\Handler\Proxy;

class ProductController extends BaseController
{
    public function __construct()
    {
        // Khai báo các thuộc tính được định nghĩa ở BaseController
        // Những resource nào chưa có thì phải tạo thêm
        $this->model = new Product();
        $this->modelCollection = ProductCollection::class;
        $this->modelResource = ProductResource::class;
        $this->modelDetailResource = ProductDetailResource::class;
        $this->modelTranslation =  new ProductTranslation();
    }
}
