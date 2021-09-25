<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            "name" => $this->name,
            "family" => $this->family,
            "national_number" => $this->national_number,
            "birthdate" => $this->birthdate,
            "roles" => $this->roles
        ];
//        return parent::toArray($request);
    }
}
