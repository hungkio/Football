<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPostsOnpageRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPostsOnPage(GetPostsOnpageRequest $request){
        $posts = Post::whereJsonContains('on_pages', $request->page_id)->get();
        
        return response()->json([
            'status' => true,
            'data' => $posts
        ]);
    }
}
