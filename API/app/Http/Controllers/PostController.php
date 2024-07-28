<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPostByIdRequest;
use App\Http\Requests\GetPostBySlugRequest;
use App\Http\Requests\GetPostsByCategoryRequest;
use App\Http\Requests\GetPostsByTagRequest;
use App\Http\Requests\GetPostsOnpageRequest;
use App\Models\Post;
use App\Models\Taxonable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getPostsOnPage(GetPostsOnpageRequest $request){
        $posts = Post::whereJsonContains('on_pages', $request->page_slug)
        ->when($request->date, function($query) use ($request){
            $query->whereDate('created_at', $request->date);
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
                            ->where('taxon_slug', $request->category_slug)
                            ->get();
            foreach ($taxonables as $taxonable) {
                $postIds[] = $taxonable->taxonable_id;
            }
            $posts = Post::whereIn('id', $postIds)
            ->when($request->date, function($query) use ($request){
                $query->whereDate('created_at', $request->date);
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
            $post->related_posts = Post::whereIn('id', $post->related_posts)->get();
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
    public function getPostBySlug(GetPostBySlugRequest $request){
        try {
            $post = Post::find($request->slug);
            $post->related_posts = Post::whereIn('id', $post->related_posts)->get();
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

    public function getPostsByTag(GetPostsByTagRequest $request){
        try {
            $posts = Post::whereJsonContains('tags', $request->tag)
                    ->when($request->date, function($query) use ($request){
                        $query->whereDate('created_at', $request->date);
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
}
