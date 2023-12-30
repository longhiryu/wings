<?php

namespace App\Http\Resources\Api\Front;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                $categories = $item->categories ? collect($item->categories)->map(function ($category) {
                    return [
                        'id'   => $category->id,
                        'name' => $category->translate('name'),
                        'slug' => $category->translate('slug'),
                    ];
                }) : null;

                return [
                    'id'       => $item->id,
                    'category' => empty($categories->toArray()) ? null : $categories,
                    'price'             => $item->price,
                    'sku'               => $item->sku,
                    'in_stock'          => $item->in_stock,
                    'is_active'         => $item->is_active,
                    'name'              => $item->translate('name'),
                    'locale'            => $item->translate('locale'),
                    'slug'              => $item->translate('slug'),
                    'short_description' => $item->translate('short_description'),
                    'image'             => $item->translate('image'),
                    'title'             => $item->translate('title'),
                    'created_at'        => Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d'),
                    'updated_at'        => Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->format('Y-m-d'),
                ];
            }),
        ];
    }
}
