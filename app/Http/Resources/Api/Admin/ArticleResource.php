<?php

namespace App\Http\Resources\Api\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'is_active' => $this->is_active,
            'name' => $this->translated->name,
            'locale' => $this->translated->locale,
            'slug' => $this->translated->slug,
            'short_description' => $this->translated->short_description,
            'image' => optional($this->file)->path,
            'title' => $this->translated->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d'),
            // 'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d'),
        ];

        return $data;
    }
}
