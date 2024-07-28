<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getPage(Request $request){
        try {
            $page = Page::where('slug', $request->slug)->first();
            return response()->json([
                'status' => true,
                'data' => $page
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'data' => $th
            ]);
        }
    }
}
