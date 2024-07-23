<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPostByIdRequest;
use App\Http\Requests\GetPostsByCategoryRequest;
use App\Http\Requests\GetPostsOnpageRequest;
use App\Models\Post;
use App\Models\Taxonable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getPostsOnPage(GetPostsOnpageRequest $request){
        $posts = Post::whereJsonContains('on_pages', $request->page_id)
        ->when($request->date, function($query) use ($request){
            $query->where('created_at', $request->date);
        })
        ->paginate($request->per_page);
        
        return response()->json([
            'status' => true,
            'data' => $posts
        ]);
    }

    public function getPostsByCategory(GetPostsByCategoryRequest $request){
        try {
            $postIds = [];
            $taxonables = Taxonable::where('taxonable_type', Taxonable::BE_POST_MODEL)
                            ->where('taxon_id', $request->category_id)
                            ->get();
            foreach ($taxonables as $taxonable) {
                $postIds[] = $taxonable->taxonable_id;
            }
            $posts = Post::whereIn('id', $postIds)
            ->when($request->date, function($query) use ($request){
                $query->where('created_at', $request->date);
            })
            ->paginate($request->per_page);
    
            return response()->json([
                'status' => true,
                'data' => $posts
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }

    public function getPostById(GetPostByIdRequest $request){
        try {
            $post = Post::find($request->post_id);
            return response()->json([
                'status' => true,
                'data' => $post,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ]);
        }
    }
}
