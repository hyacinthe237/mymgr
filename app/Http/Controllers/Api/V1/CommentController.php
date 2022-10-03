<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Save a comment
     */
    public function store (Request $request)
    {
        try 
        {
            $user = $request->user();
            $payload = $request->all();
            $payload['user_id'] = $user->id;

            $comment = Comment::create($payload);
            return response()->json($comment);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
