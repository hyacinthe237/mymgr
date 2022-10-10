<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Organization extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'official_name' => $this->official_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'admin' => new User($this->admin),
            'status' => $this->status
        ];
    }
}
