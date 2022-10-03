<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'status'    => $this->status,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'date_cleared'  => $this->description,
            'notes'         => $this->notes,
            'amount'        => $this->amount,

            'user' => [
                'id'        => $this->user->id,
                'code'      => $this->user->code,
                'firstname' => $this->user->firstname,
                'lastname'  => $this->user->lastname
            ],

            'booking' => [
                'code'    => $this->booking->code,
                'number'  => $this->booking->number,
            ],

            'clearedby' => $this->cleared_by ? [
                'id'        => $this->clearedBy->id,
                'code'      => $this->clearedBy->code,
                'firstname' => $this->clearedBy->firstname,
                'lastname'  => $this->clearedBy->lastname
            ] : []
        ];
    }
}
