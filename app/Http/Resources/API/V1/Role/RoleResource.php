<?php

namespace App\Http\Resources\API\V1\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "name" => $this->name,
            "level" => $this->level,
            "created_at" => date("Y-m-d H:i:s",strtotime($this->created_at)),
            "updated_at" => date("Y-m-d H:i:s",strtotime($this->updated_at)),
        ];
//        return parent::toArray($request);
    }
}
