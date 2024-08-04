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
            })
            ->when($request->country_standing_page, function($query) use ($request){
                $query->where('shown_on_country_standing', true);
            })
            ->when($request->exclude_popular, function($query){
                $popularLeagues = League::where('popular', League::POPULAR)->pluck('id')->toArray();
                $query->whereNotIn('id', $popularLeagues);
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($request->per_page);
            return response()->json($leagues);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }

    public function popularLeagues(){
        try {
            $leagues = League::where('popular', League::POPULAR)->get();
            return response()->json($leagues);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }
}
