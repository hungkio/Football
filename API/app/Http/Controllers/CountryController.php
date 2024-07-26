<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request){
        try {
            $countries = Country::when($request->keyword, function($query) use ($request){
                $query->where('name','like', $request->keyword . '%')
                      ->orWhere('code', 'like', $request->keyword . '%');
            })->paginate($request->per_page);
            return response()->json([
                'status' => true,
                'data' => $countries
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }
}
