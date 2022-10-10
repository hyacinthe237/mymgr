<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
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
            'items' => $this->collection->transform(function($comment){
                return [
                    'id'                => $comment->id,
                    'code'              => $comment->code,
                    'body'              => $comment->body,
                    'commentable_type'  => $comment->commentable_type,
                    'created_at'        => $comment->created_at->format('Y-m-d H:i:s'),
                    'owner'             => new User($comment->owner)
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
