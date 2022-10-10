<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketCategoryCollection extends ResourceCollection
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
            'items' => $this->collection->transform(function($ticketCatgory){
                return [
                    'id' => $ticketCatgory->id,
                    'name' => $ticketCatgory->name,
                    'code' => $ticketCatgory->code,
                    'organization' => new Organization($ticketCatgory->organization)
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
