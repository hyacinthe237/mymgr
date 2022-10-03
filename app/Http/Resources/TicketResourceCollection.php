<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tickets = [];
        $chunks = $this->collection->values()->chunk(100);

        foreach ($chunks as $collection) {
            foreach ($collection as $item) {
                $tickets[] = $this->pushData($item);
            }
        }

        return [
            'data' => $tickets,
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage(),
        ];
    }


    private function pushData ($item) 
    {
        return (Object) [
            'id'        => $item->id,
            'code'      => $item->code,
            'title'     => $item->title,
            'status'    => $item->status,
            'number'    => $item->number,
            'created_at'  => $item->created_at,
            'updated_at'  => $item->updated_at,
            'description' => $item->description,

            'client' => [
                'id'        => $item->client->id,
                'code'      => $item->client->code,
                'firstname' => $item->client->firstname,
                'lastname'  => $item->client->lastname
            ],

            'assignee' => $item->assignee_id ? [
                'id'        => $item->assignee->id,
                'code'      => $item->assignee->code,
                'firstname' => $item->assignee->firstname,
                'lastname'  => $item->assignee->lastname
            ] : [],

            'updater' => $item->updated_by ? [
                'id'        => $item->updater->id,
                'code'      => $item->updater->code,
                'firstname' => $item->updater->firstname,
                'lastname'  => $item->updater->lastname
            ] : [],
        ];
    }
}
