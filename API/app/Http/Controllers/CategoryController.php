<?php

namespace App\Http\Controllers;

use App\Models\Taxon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getPostCategories(){
        try {
            $categories = Taxon::where('taxonomy_id', Taxon::CATEGORY)
                ->where('parent_id', null)
                ->with('allChildren')
                ->get();
            return response()->json([
                'status' => true,
                'data' => $categories
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => $th
            ]);
        }
    }
}
