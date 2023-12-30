<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Api\Admin\ChannelCollection;
use App\Http\Resources\Api\Admin\ChannelDetailResource;
use App\Http\Resources\Api\Admin\ChannelResource;
use App\Models\Channel;


class ChannelController extends BaseController
{
    public function __construct()
    {
        // Khai báo các thuộc tính được định nghĩa ở BaseController
        // Những resource nào chưa có thì phải tạo thêm
        $this->model = new Channel();
        $this->modelCollection = ChannelCollection::class ;
        $this->modelResource = ChannelResource::class ;
        $this->modelDetailResource = ChannelDetailResource::class;        
    }
}
