<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'id'        => $this->id,
            'code'      => $this->code,
            'title'     => $this->title,
            'status'    => $this->status,
            'number'    => $this->number,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'description' => $this->description,

            'client' => [
                'id' => $this->client->id,
                'code' => $this->client->code,
                'firstname' => $this->client->firstname,
                'lastname'  => $this->client->lastname,
            ],

            'assignee' => $this->assignee ? [
                'id' => $this->assignee->id,
                'code' => $this->assignee->code,
                'firstname' => $this->assignee->firstname,
                'lastname'  => $this->assignee->lastname,
            ] : [],

            'updater' => $this->updated_by ? [
                'id'      => $this->updater->id,
                'code'      => $this->updater->code,
                'firstname' => $this->updater->firstname,
                'lastname'  => $this->updater->lastname
            ] : [],

            'comments' => $this->comments->map(function ($item) {
                return (object) [
                    'user_id' => $item->user_id,
                    'content' => $item->content,
                    'created_at' => $item->created_at,
                    'user_code' => $item->user->code,
                    'user_name' => $item->user->firstname . ' ' . $item->user->lastname
                ];
            })
        ];
    }
}
