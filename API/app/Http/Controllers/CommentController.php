<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCommentsFromPostRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getCommentsFromPost(GetCommentsFromPostRequest $request){
        try {
            $comments = Comment::where('post_id', $request->post_id)->where('parent_id', null)->get();
            foreach ($comments as $comment) {
                $comment->replies = Comment::where('post_id', $request->post_id)->where('parent_id', $comment->id)->get();
            }
            return response()->json($comments);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }
}
