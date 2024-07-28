<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function index(Request $request){
        try {
            $countries = Country::select('countries.*, regions.name_vi region_vi, subregion.name_vi subregion_vi')->when($request->keyword, function($query) use ($request){
                $query->where('name', 'like', $request->keyword . '%')
                      ->orWhere('code', 'like', $request->keyword . '%');
            })
            ->join('regions', 'countries.region_id', '=', 'regions.id')
            ->join('subregion', 'countries.subregion_id', '=', 'subregion.id')
            ->paginate($request->per_page);
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
    public function nationalTeam(Request $request){
        $leagues = DB::table('countries')
        ->select('countries.*, regions.name_vi region_vi, subregion.name_vi subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregion', 'countries.subregion_id', '=', 'subregion.id')
        ->where('countries.name', 'like', $request->keyword.'%')->orWhere('code', 'like', $request->keyword . '%')
        ->get();
    }
}
