<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Api\Admin\CategoryCollection;
use App\Http\Resources\Api\Admin\CategoryDetailResource;
use App\Http\Resources\Api\Admin\CategoryResource;
use App\Models\Category;
use App\Models\CategoryTranslation;

class CategoryController extends BaseController
{
   public function __construct()
   {
      // Khai báo các thuộc tính được định nghĩa ở BaseController
      // Những resource nào chưa có thì phải tạo thêm
      $this->model = new Category(); //new 1 đối tường là xài luôn
      $this->modelCollection = CategoryCollection::class;
      $this->modelResource = CategoryResource::class;
      $this->modelDetailResource = CategoryDetailResource::class;   
      $this->modelTranslation = new CategoryTranslation();
   }
}
