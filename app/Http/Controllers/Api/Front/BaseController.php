<?php

namespace App\Http\Controllers\Api\Front;

use App;
use App\Exceptions\Api\NotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseController extends Controller
{
    const BASE_LIMIT = 'limit';

    public $model;
    public $resource;
    public $collection;
    public $translation;
    protected $limit = 10;
    protected $max_limit = 100;

    public function __construct()
    {
    }

    /**
     * index function
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $limit = $this->limitPerPage($params[self::BASE_LIMIT] ?? $this->limit);

        $data = $this->model->paginate($limit);
        return new $this->collection($data);
    }

    /**
     * show function
     *
     * @param integer $id
     * @return JsonResource
     */
    public function show(int $id)
    {
        $data = $this->model->find($id);

        return new $this->resource($data);
    }

    /**
     * getDetailBySlug function
     *
     * @param string $slug
     * @return JsonResource
     */
    public function getDetailBySlug(string $slug)
    {
        $data = null;

        if ($this->translation) {
            $data = $this->model->whereHas('translated', function ($item) use ($slug) {
                $item->where('slug', $slug);
            })->first();
        } else {
            $data = $this->model->where('slug', $slug)->first();
        }

        if ($data) {
            return new $this->resource($data);
        }

        throw new NotFoundException();
    }

    /**
     * limitPerPage function
     * limit rows perpage
     * @param integer $limit
     * @return integer
     */
    protected function limitPerPage(int $limit): int
    {
        $limited = ($limit <= $this->max_limit) ? $limit : $this->max_limit;
        return $limited;
    }
}
