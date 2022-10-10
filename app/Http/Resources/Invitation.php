<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Invitation extends JsonResource
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
            'status' => $this->status,
            'user' => new User($this->user),
            'organization' => new Organization($this->organization),
            'messsage' => $this->messsage
        ];
    }
}
