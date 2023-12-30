<?php

namespace App\Http\Controllers\Api\Admin;

use App\Sys\SysCore;
use App\Sys\SysData;
use App\Http\Controllers\Controller;
use App\Sys\Api\SysApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BaseController extends Controller
{
    protected $SysCore;
    protected $SysData;
    protected $sysApi;
    protected $model;
    protected $translation = null;
    protected $collection;
    protected $resource;
    protected $limit = 10;
    protected $orderBy = 'created_at';
    protected $orderType = 'DESC';
    protected $column = 'slug';
    protected $table;
    protected $tableTranslation;

    public function __construct()
    {
        $this->SysCore = new SysCore();
        $this->SysData = new SysData();
        $this->sysApi = new SysApi();
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $data = $this->sysApi->getData($this->model, $params);

        return new $this->collection($data);
    }

    public function query_builder()
    {
        $query = $this->model;
        if (request()->has('search')) {
            $query = $this->SysData->search($query, $this->model);
        }

        if (request()->has('filter')) {
            $query = $this->SysData->filter($query);
        }

        return $this->sort_and_paginate($query);
    }

    public function sort_and_paginate($query)
    {
        $request = (object) request()->all();
        $limit = isset($request->limit) && $request->limit != null ? $request->limit : $this->limit;
        $orderBy = isset($request->orderBy) && $request->orderBy != null ? $request->orderBy : $this->orderBy;
        $orderType = isset($request->orderType) && $request->orderType != null ? $request->orderType : $this->orderType;

        return $query->orderBy($orderBy, $orderType)->paginate($limit);
    }

    public function detailBySlug(string $slug)
    {
        $data = $this->SysData->getDetailBySlug($slug, $this->model);

        return $data ? new $this->modelDetailResource($data) : $this->notFound();
    }

    public function show(int $id)
    {
        $data = $this->SysData->show($id, $this->model);

        return $data ? new $this->modelDetailResource($data) : $this->notFound();
    }

    public function notFound()
    {
        return response()->json(['Data not found'], 404);
    }

    public function notFoundColumn()
    {
        return response()->json(['Not found Column'], 404);
    }

    public function listSlug()
    {
        $result = [];

        if (Schema::hasColumn($this->model->getTable(), 'slug')) {
            $data = $this->model->select('slug')->get();
            foreach ($data as  $item) {
                $result[] = $item->slug;
            }
        } elseif ($this->modelTranslation && Schema::hasColumn($this->modelTranslation->getTable(), 'slug')) {
            $data = $this->modelTranslation::select('slug')->get();
            foreach ($data as $item) {
                $result[] = $item->slug;
            }
        } else {
            return $this->notFoundColumn();
        }

        return response()->json($result, 200);
    }
}
