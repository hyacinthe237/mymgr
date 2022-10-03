<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bookings = [];
        $chunks = $this->collection->values()->chunk(100);

        foreach ($chunks as $collection) {
            foreach ($collection as $item) {
                $bookings[] = $this->pushData($item);
            }
        }

        return [
            'data' => $bookings,
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage()
        ];
    }


    private function pushData ($item) 
    {
        return (Object) [
            'id'        => $item->id,
            'code'      => $item->code,
            'notes'     => $item->notes,
            'status'    => $item->status,
            'number'    => $item->number,
            'amount'    => $item->amount,
            'ratings'   => $item->ratings,
            'end_time'  => $item->end_time,
            'start_time'=> $item->start_time,

            'chef' => [
                'sex'       => $item->chef->sex,
                'code'      => $item->chef->code,
                'email'     => $item->chef->email,
                'state'     => $item->chef->state,
                'suburb'    => $item->chef->suburb,
                'status'    => $item->chef->status,
                'username'  => $item->chef->username,
                'firstname' => $item->chef->firstname,
                'thumbnail' => $item->chef->thumbnail,
                'lastname'  => $item->chef->lastname,
                'postcode'  => $item->chef->postcode,
                'address'   => $item->chef->address,
                'profile'   => $item->chef->profile
            ],

            'client' => [
                'sex'       => $item->client->sex,
                'code'      => $item->client->code,
                'email'     => $item->client->email,
                'state'     => $item->client->state,
                'suburb'    => $item->client->suburb,
                'status'    => $item->client->status,
                'username'  => $item->client->username,
                'firstname' => $item->client->firstname,
                'thumbnail' => $item->client->thumbnail,
                'lastname'  => $item->client->lastname,
                'postcode'  => $item->client->postcode,
                'address'   => $item->client->address,
                'profile'   => $item->client->profile
            ],

            'dishes' => $item->dishes->map(function ($dish) {
                return [
                    'code'          => $dish->code,
                    'name'          => $dish->name,
                    'name'          => $dish->name,
                    'price'         => $dish->price,
                    'serves'        => $dish->serves,
                    'duration'      => $dish->duration,
                    'ingredients'   => $dish->ingredients,
                    'description'   => $dish->description,
                ];
            })
        ];
    }
}
