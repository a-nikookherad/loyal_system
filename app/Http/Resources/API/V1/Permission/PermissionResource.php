<?php

namespace App\Http\Resources\API\V1\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
//            "key" => $this->key,
            "controller" => $this->controller,
            "method" => $this->method,
            "active" => $this->active,
            "created_at" => date("Y-m-d H:i:s", strtotime($this->created_at)),
            "updated_at" => date("Y-m-d H:i:s", strtotime($this->updated_at)),
        ];
//        return parent::toArray($request);
    }
}
