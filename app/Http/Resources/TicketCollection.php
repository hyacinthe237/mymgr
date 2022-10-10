<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketCollection extends ResourceCollection
{
     /**
     * The attributes that should force wrapping data.
     *
     * @var string
     */
    public static $wrap = 'items';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'items' => $this->collection->transform(function($ticket){
                return [
                    'id' => $ticket->id,
                    'status' => $ticket->status,
                    'title' => $ticket->title,
                    'description' => $ticket->description,
                    'priority' => $ticket->priority,
                    'complexity' => $ticket->complexity,
                    'project' => !is_null($ticket->project) ? new Project($ticket->project) : null ,
                    'created_by' => !is_null($ticket->createdBy) ? new User ($ticket->createdBy) : null ,
                    'assignee' =>  !is_null($ticket->assignee) ? new User($ticket->assignee) : null ,
                    'assignee_id' => $ticket->assignee_id,
                    'number' => $ticket->number,
                    'start_date' => $ticket->start_date,
                    'end_date' => $ticket->end_date,
                    'estimate' => $ticket->estimate,
                    'created_at' => $ticket->created_at,
                    'category' => $ticket->category,
                    'is_open'  => $ticket->is_open
                ];
            })
        ];
    }
}
