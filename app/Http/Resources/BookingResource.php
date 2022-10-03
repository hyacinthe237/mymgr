<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $chefRatingsCount   = $this->chef->ratings_count ?? 1;
        $clientRatingsCount = $this->client->ratings_count ?? 1;

        $chefStars   = (int)$this->chef->ratings / $chefRatingsCount;
        $clientStars = (int)$this->client->ratings / $clientRatingsCount;

        return [
            'id'        => $this->id,
            'code'      => $this->code,
            'notes'     => $this->notes,
            'status'    => $this->status,
            'amount'    => $this->amount,
            'number'    => $this->number,
            'end_time'  => $this->end_time,
            'start_time'=> $this->start_time,

            'chef' => [
                'sex'       => $this->chef->sex,
                'code'      => $this->chef->code,
                'email'     => $this->chef->email,
                'state'     => $this->chef->stage,
                'suburb'    => $this->chef->suburb,
                'status'    => $this->chef->status,
                'username'  => $this->chef->username,
                'firstname' => $this->chef->firstname,
                'thumbnail' => $this->chef->thumbnail,
                'lastname'  => $this->chef->lastname,
                'postcode'  => $this->chef->postcode,
                'address'   => $this->chef->address,
                'profile'   => $this->chef->profile,
                'stars'     => $chefStars,
            ],
            
            'client' => [
                'sex'       => $this->client->sex,
                'code'      => $this->client->code,
                'email'     => $this->client->email,
                'state'     => $this->client->state,
                'suburb'    => $this->client->suburb,
                'status'    => $this->client->status,
                'username'  => $this->client->username,
                'firstname' => $this->client->firstname,
                'thumbnail' => $this->client->thumbnail,
                'lastname'  => $this->client->lastname,
                'postcode'  => $this->client->postcode,
                'address'   => $this->client->address,
                'profile'   => $this->client->profile,
                'stars'     => $clientStars,
            ],

            'dishes' => $this->dishes->map(function ($dish) {
                return [
                    'code'          => $dish->code,
                    'name'          => $dish->name,
                    'name'          => $dish->name,
                    'price'         => $dish->price,
                    'serves'        => $dish->serves,
                    'duration'      => $dish->duration,
                    'ingredients'   => $dish->ingredients,
                    'description'   => $dish->description
                ];
            }),

            'comments' => $this->comments->map(function ($item) {
                return (object) [
                    'user_id' => $item->user_id,
                    'content' => $item->content,
                    'created' => $item->created_at,
                ];
            }),

            'ratings' => $this->rates->map(function ($item) {
                return (object) [
                    'created' => $item->created_at,
                    'rater'   => $item->rater->code,
                    'ratee'   => $item->ratee->code,
                    'stars'   => $item->stars,
                    'extra'   => $item->extra
                ];
            })
        ];
    }
}
