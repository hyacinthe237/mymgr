<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
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
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'complexity' => $this->complexity,
            'project' => new Project($this->project),
            'created_by' => new User($this->createdBy),
            'assignee' => new User($this->assignee),
            'assignee_id' => $this->assignee_id,
            'number' => $this->number,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'estimate' => $this->estimate,
            'files' => $this->files
        ];
    }
}
