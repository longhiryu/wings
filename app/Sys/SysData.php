<?php

namespace App\Sys;

use App\Models\Category;
use Session;
use Illuminate\Support\Facades\Schema;

class SysData
{
    private $data;
    /**
     * Method getData
     * Get data from model and params
     * @param $model $model
     * @param $pars $pars['key' => value]
     *
     * @return Collection
     */
    public function getData($model, $pars = [])
    {
        $param = (object) $pars;
        $this->data = $model::query();

        // keyword
        $this->filterByKeyword($model, $param);

        // values
        $this->filterByVal($param);

        // sort data
        if (isset($param->sortBy)) {
            if (is_array($param->sortBy) && !empty($param->sortBy)) {
                foreach ($param->sortBy as $value) {
                    $this->data->orderBy($value, $param->sortType);
                }
            } else {
                $this->data->orderBy($param->sortBy, $param->sortType);
            }
        }

        //low_quantity
        if (isset($param->low_quantity) && $param->low_quantity == 1) {
            $this->data->where('product_quantity', '<=', 10);
        }

        //channel
        $this->filterByChannel($model);

        // return
        return isset($param->limit) ? $this->data->paginate($param->limit) : $this->data->get();
    }

    private function filterByKeyword($model, $param)
    {
        $keyword = $param->keyword ?? null;
        $searchField = $param->searchField ?? null;

        if ($keyword != null) {
            if ($searchField && is_array($searchField)) {
                $this->data->where(function ($subquery) use ($searchField, $model, $keyword) {
                    foreach ($searchField as $value) {
                        if (in_array($value, $model->getFillable())) {
                            $subquery->orWhere($value, 'like', '%' . $keyword . '%');
                        } else {
                            if (method_exists($model, 'translatedModel')) {
                                $translatedModel = $model->translatedModel();
                                if (in_array($value, $translatedModel->getFillable())) {
                                    $subquery->orWhereHas('translated', function ($query) use ($value, $keyword) {
                                        return $query->where($value, 'like', '%' . $keyword . '%');
                                    });
                                }
                            }
                        }
                    }
                });
            } elseif($searchField) {
                if (in_array($searchField, $model->getFillable())) {
                    $this->data->orWhere($searchField, 'like', '%' . $keyword . '%');
                } else {
                    if (method_exists($model, 'translatedModel')) {
                        $translatedModel = $model->translatedModel();
                        if (in_array($searchField, $translatedModel->getFillable())) {
                            $this->data->orWhereHas('translated', function ($query) use ($searchField, $keyword) {
                                return $query->where($searchField, 'like', '%' . $keyword . '%');
                            });
                        }
                        
                    }
                }
            }
        }
    }

    private function filterByVal($param)
    {
        $vals = [
            'material',
            'is_active',
            'parent_id',
            'category_id',
            'user_id',
            'supplier_id',
            'customer_id',
            'inventory_id',
            'order_id',
            'type'
        ];
        foreach ($vals as $key) {
            if (property_exists($param, $key)) {
                switch ($key) {
                    case 'category_id':
                        $id = $param->$key;
                        $category = Category::find($id);
                        $childs = $category->children()->pluck('id')->toArray();
                        array_push($childs, (int) $id);

                        $this->data->whereIn('category_id', $childs);
                        break;

                    default:
                        $this->data->where($key, $param->$key);

                        break;
                }
            }
        }
    }

    private function filterByChannel($model)
    {
        if (method_exists($model, 'channels') && class_basename($model) != 'Channel' && Session::get('channel') != null) {
            $channel = Session::get('channel');
            $this->data->whereHas('channels', function ($item) use ($channel) {
                return $item->where('channel_id', $channel->id);
            });
        }
    }

    public function show(int $id, $model)
    {
        return $model->find($id);
    }
}
