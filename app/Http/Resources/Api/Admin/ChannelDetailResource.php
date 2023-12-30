<?php

namespace App\Http\Resources\Api\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChannelDetailResource extends JsonResource
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
            "id"=>$this->id,
            "name"=> $this->name,
            "slug"=> $this->slug,
            "is_active"=> $this->is_active,
            "is_default"=> $this->is_default,	
            "deleted_at"=> $this->deleted_at,	
            "created_at"=> Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d'),
            "updated_at"=> Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d'),
        ];
    }
}
