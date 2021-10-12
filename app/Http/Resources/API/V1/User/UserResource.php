<?php

namespace App\Http\Resources\API\V1\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "name" => $this->name,
            "family" => $this->family,
            "mobile" => $this->mobile,
            "email" => $this->email,
            "national_number" => $this->national_number,
            "birthdate" => $this->birthdate,
            "email_verified_at" => $this->email_verified_at,
            "login_type" => $this->login_type,
//            "password" => $this->password,
            "remember_token" => $this->remember_token,
            "deleted_at" => $this->deleted_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "roles" => $this->whenLoaded("roles", $this->roles)
        ];
    }
}
