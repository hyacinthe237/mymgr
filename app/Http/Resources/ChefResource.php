<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChefResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sex' => $this->sex,
            'code' => $this->code,
            'email' => $this->email,
            'state' => $this->stage,
            'suburb' => $this->suburb,
            'status' => $this->status,
            'role_id' => $this->role_id,
            'username' => $this->username,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'firstname' => $this->firstname,
            'thumbnail' => $this->thumbnail,
            'lastname' => $this->lastname,
            'postcode' => $this->postcode,
            'address' => $this->address,
            'profile' => $this->profile,
            'ratings' => $this->ratings,
            'mobile' => $this->mobile
        ];
    }
}
