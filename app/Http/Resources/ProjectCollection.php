<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
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
            'items' => $this->collection->transform(function($project){
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'description' => $project->description,
                    'code' => $project->code,
                    'status' => $project->status,
                    'goal' => $project->goal,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'is_public' => $project->is_public,
                    'owner' => new User($project->owner),
                    'organization' => new Organization($project->organization),
                    'created_by' => new User($project->createdBy),
                    'category' => new ProjectCategory($project->category),
                    //'tickets' => new TicketCollection($project->tickets),
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
