<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BaseController extends Controller
{
    public $model;

    public $modelName;

    public $modelView;

    public $translatedModel;

    public $itemsPerPage = 10;

    public $sortBy = 'id';

    public $orderBy = 'DESC';

    public function __construct()
    {
        if ($this->model) {
            $this->modelName = class_basename($this->model);
            $this->modelView = 'backend.layouts.' . strtolower($this->modelName);
            if (method_exists($this->model, 'translatedModel')) {
                $this->translatedModel = $this->model->translatedModel();
            }
        }
    }

    public function index()
    {
        // check permissions index
        $this->authorize('index', $this->model);

        $data = $this->query_builder($this->model);

        $fillable = isset($this->translatedModel) ?
        array_merge($this->model->getFillable(), $this->translatedModel->getFillable()) :
        $this->model->getFillable();

        $baseName = strtolower($this->modelName);

        return view($this->modelView . '.index', compact('data', 'fillable', 'baseName'));
    }

    public function query_builder($q)
    {
        // channel
        $this->channel_data($q);

        // search
        $this->search($q);

        return $this->sort_and_paginate($q);
    }

    public function channel_data($q)
    {
        // Get data belong to channel
        $channel = session()->get('channel');
        if ($channel && method_exists($q, 'channel')) {
            $q = $q->whereHas('channels', function ($query) use ($channel) {
                $query->where('slug', $channel->slug);
            });
        }

        return $q;
    }

    public function search($q)
    {
        if (request()->has('search')) {
            $search = request('search');
            foreach ($search as $key => $value) {
                list($keyword, $condition) = explode(':', $key);
                switch ($condition) {
                    case 'like':
                        $q = $q->where($keyword, $condition, '%' . $value . '%');

                        break;
                    case 'is':
                        $q = $q->where($keyword, $value);

                        break;
                    case 'in':
                        $value = explode(',', $value);
                        $q = $q->whereIN($keyword, $value);

                        break;
                    default:
                        // code...
                        break;
                }
            }
        }
        if (isset($_GET['keywords'])) {
            $keyword = $_GET['keywords'];
            $search = $_GET['search_field'];
            if (method_exists($q, 'translated')) {
                $q = $q->whereHas('translated', function ($query) use ($keyword, $search) {
                    $query->where($search, 'LIKE', '%' . $keyword . '%');
                });
            } else {
                $q = $q->where($search, 'LIKE', '%' . $keyword . '%');
            }
        }

        return $q;
    }

    public function sort_and_paginate($q)
    {
        return $q->orderBy($this->sortBy, $this->orderBy)->paginate($this->itemsPerPage);
    }

    public function get_trashed()
    {
        $data = null;
        if (method_exists($this->model, 'forceDelete')) {
            $data = $this->query_builder($this->model->onlyTrashed());
        }

        return view('backend.layouts.' . strtolower($this->modelName) . '.trashed', compact('data'));
    }

    public function insert_data($data, $model = null)
    {
        $this->authorize('create', $this->model);

        $new = null;

        //check if model has slug attribute with no translation table
        if (in_array('slug', $this->model->getFillable())) {
            $data['slug'] = Str::slug(($data['name'] ?? $data['title'] ?? $data['slug'] ?? 'no_slug'));
        }

       try {
            if ($model != null) {
                //update record
                //$this->model::find($model->id)
                $model->update(
                    collect($data)
                    ->only($model->getFillable())
                    ->toArray()
                );
                
            } else {
                // create record
                $new = $this->model::create(
                    collect($data)
                    ->only($this->model->getFillable())
                    ->toArray()
                );
            }

            Session::flash('status', 'Data is saved or udpated successfully!');
        } catch (\Throwable $th) {
            Session::flash('error', 'Something wrong in BaseController function insert_data()!');
        }

        return redirect()->route(strtolower($this->modelName) . '.edit', $new ? $new->id : $model->id);
    }

    public function create()
    {
        $this->authorize('create', $this->model);

        $data = $this->model;

        return view($this->modelView . '.create', compact('data'));
    }

    public function edit(int $id)
    {
        $this->authorize('edit', $this->model);

        $data = $this->model::find($id);

        return view($this->modelView . '.edit', compact('data'));
    }

    public function destroy(int $id)
    {
        $this->authorize('delete', $this->model);

        $result = $this->model::destroy($id);

        return $result ? 'deleted' : 'error';
    }

    public function show_ajax(int $id)
    {
        $data = $this->model::find($id);

        if ($data) {
            return view($this->modelView . '.show_ajax', compact('data'));
        }

        return false;
    }

    public function changeLanguage(string $lang)
    {
        session()->put('lang', $lang);

        return redirect()->back();
    }

    

    public function searchAjaxProduct()
    {
        $keyword = request('keyword');
        $data = null;
        if (method_exists($this->model, 'translated')) {
            $data = $this->model::whereHas('translated', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })->limit(5)->get();
        } else {
            $data = $this->model::where('name', 'like', '%' . $keyword . '%')->limit(5)->get();
        }

        if ($data) {
            return $data->toArray();
        }

        return response()->json(['Not found'], 404);
    }
}
