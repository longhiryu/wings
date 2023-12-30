<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->translate('name'),
            'locale' => $this->translate('locale'),
            'image' => $this->translate('image'),
            'slug' => $this->translate('slug'),
            'title' => $this->translate('title'),
            //'short_description' => $this->translated->short_description,
            //'long_description' => $this->translated->long_description,
            'parent_id' => $this->parent_id,
            'position' => $this->position,
            'is_active' => $this->is_active,
            'type' => $this->type,
        ];
    }
}
