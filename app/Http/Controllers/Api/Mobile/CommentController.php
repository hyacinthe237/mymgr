<?php

namespace App\Http\Controllers\Api\Mobile;

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
            $request->user_id = $user->id;

            $comment = Comment::create($request->all());
            return response()->json($comment);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
