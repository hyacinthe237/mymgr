<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $models = [];
        $chunks = $this->collection->values()->chunk(100);

        foreach ($chunks as $collection) {
            foreach ($collection as $item) {
                $models[] = $this->pushData($item);
            }
        }

        return [
            'data' => $models,
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
            'status'    => $item->status,
            'created_at'    => $item->created_at,
            'updated_at'    => $item->updated_at,
            'date_cleared'  => $item->description,
            'notes'         => $item->notes,
            'amount'        => $item->amount,

            'user' => [
                'id'        => $item->user->id,
                'code'      => $item->user->code,
                'firstname' => $item->user->firstname,
                'lastname'  => $item->user->lastname
            ],

            'booking' => [
                'code'    => $item->booking->code,
                'number'  => $item->booking->number,
            ],

            'clearedby' => $item->cleared_by ? [
                'id'        => $item->clearedBy->id,
                'code'      => $item->clearedBy->code,
                'firstname' => $item->clearedBy->firstname,
                'lastname'  => $item->clearedBy->lastname
            ] : []
        ];
    }
}
