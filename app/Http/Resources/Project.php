<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'code' => $this->code,
            'status' => $this->status,
            'goal' => $this->goal,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_public' => $this->is_public,
            'owner' => new User($this->owner),
            'organization' => new Organization($this->organization),
            'category' => new ProjectCategory($this->category),
            'created_by' => new User($this->createdBy),
            'files' => $this->files
        ];
    }
}
