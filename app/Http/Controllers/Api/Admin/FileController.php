<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\File;
use App\Http\Resources\Api\Admin\FileResource;
use App\Http\Resources\Api\Admin\FileCollection;
use App\Http\Controllers\Api\Admin\BaseController;

class FileController extends BaseController
{
    public function __construct()
    {
        $this->model = new File(); //new 1 đối tường là xài luôn
        $this->modelCollection = FileCollection::class;
        $this->modelResource = FileResource::class;
        $this->table = 'files';
    }
}
