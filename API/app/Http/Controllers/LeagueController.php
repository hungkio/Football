<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index(Request $request){
        try {
            $leagues = League::when($request->country_slug, function($query) use ($request){
                $country = Country::where('slug', $request->country_slug)->first();
                $query->where('country_code', $country->code);
            })->paginate($request->per_page);
            return response()->json([
                'status' => true,
                'data' => $leagues
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }
}
