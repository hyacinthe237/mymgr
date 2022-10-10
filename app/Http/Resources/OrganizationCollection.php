<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationCollection extends ResourceCollection
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
            'items' => $this->collection->transform(function($organization){
                return [
                    'id' => $organization->id,
                    'code' => $organization->code,
                    'name' => $organization->name,
                    'official_name' => $organization->official_name,
                    'address' => $organization->address,
                    'phone' => $organization->phone,
                    'admin' => new User($organization->admin),
                    'status' => $organization->status
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
