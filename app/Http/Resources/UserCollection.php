<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'items' => $this->collection->transform(function($user){
                return [
                    'id' => $user->id,
                    'code' => $user->code,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'status' => $user->status,
                    'photo' => $user->photo,
                    'dob' => $user->dob,
                    'gender' => $user->gender
                        ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
