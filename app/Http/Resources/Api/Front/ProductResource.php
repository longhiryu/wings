<?php

namespace App\Http\Resources\Api\Front;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $categories = $this->categories ? collect($this->categories)->map(function ($category) {
            return [
                'id'   => $category->id,
                'name' => $category->translate('name'),
                'slug' => $category->translate('slug'),
            ];
        }) : null;

        return [
            'id'       => $this->id,
            'category' => empty($categories->toArray()) ? null : $categories,
            'price'             => $this->price,
            'sku'               => $this->sku,
            'in_stock'          => $this->in_stock,
            'is_active'         => $this->is_active,
            'name'              => $this->translate('name'),
            'locale'            => $this->translate('locale'),
            'slug'              => $this->translate('slug'),
            'short_description' => $this->translate('short_description'),
            'image'             => $this->translate('image'),
            'title'             => $this->translate('title'),
            'created_at'        => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d'),
            'updated_at'        => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d'),
        ];
    }
}
