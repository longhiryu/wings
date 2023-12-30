<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Api\Admin\TagCollection;
use App\Http\Resources\Api\Admin\TagDetailResource;
use App\Http\Resources\Api\Admin\TagResource;
use App\Models\Tag;

class TagController extends BaseController
{
    public function __construct()
    {
        // Khai báo các thuộc tính được định nghĩa ở BaseController
        // Những resource nào chưa có thì phải tạo thêm
        $this->model = new Tag();
        $this->modelCollection = TagCollection::class ;
        $this->modelResource = TagResource::class ;
        $this->modelDetailResource = TagDetailResource::class;        
    }
}