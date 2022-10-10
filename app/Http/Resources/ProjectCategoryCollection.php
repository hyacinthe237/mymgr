<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCategoryCollection extends ResourceCollection
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
            'items' => $this->collection->transform(function($projectCatgory){
                return [
                    'id' => $projectCatgory->id,
                    'name' => $projectCatgory->name,
                    'code' => $projectCatgory->code,
                    'organization' => new Organization($projectCatgory->organization)
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
