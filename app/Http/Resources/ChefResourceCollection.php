<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChefResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $chefs = [];
        $chunks = $this->collection->values()->chunk(100);

        foreach ($chunks as $collection) {
            foreach ($collection as $chef) {
                $chefs[] = $this->pushChef($chef);
            }
        }

        return [
            'data' => $chefs
        ];
    }


    private function pushchef ($chef)
    {
        return (Object) [
            'id' => $chef->id,
            'sex' => $chef->sex,
            'code' => $chef->code,
            'email' => $chef->email,
            'state' => $chef->stage,
            'suburb' => $chef->suburb,
            'status' => $chef->status,
            'role_id' => $chef->role_id,
            'username' => $chef->username,
            'created_at' => $chef->created_at,
            'updated_at' => $chef->updated_at,
            'firstname' => $chef->firstname,
            'thumbnail' => $chef->thumbnail,
            'lastname' => $chef->lastname,
            'postcode' => $chef->postcode,
            'address' => $chef->address,
            'profile' => $chef->profile,
            'ratings' => $chef->ratings,
            'mobile' => $chef->mobile
        ];
    }
}
