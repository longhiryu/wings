<?php

namespace App\Http\Resources\Api\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'channels' => !$item->channels->isEmpty() ? $item->channels->map(function($channel){
                        return collect($channel->toArray())->only(['id', 'name']);
                    }) : null,
                    'is_active' => $item->is_active,
                    'name' => $item->translated->name,
                    'locale' => $item->translated->locale,
                    'slug' => $item->translated->slug,
                    'short_description' => $item->translated->short_description,
                    'image' => optional($item->file)->path,
                    'title' => $item->translated->title,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    // 'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d'),
                    // 'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d'),
                ];
            }),
        ];
    }
}
