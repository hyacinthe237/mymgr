<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InvitationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'items' => $this->collection->transform(function($invitation){
                return [
                    'id' => $invitation->id,
                    'code' => $invitation->code,
                    'status' => $invitation->status,
                    'user' => new User($invitation->user),
                    'organization' => new Organization($invitation->organization),
                    'messsage' => $invitation->messsage
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
