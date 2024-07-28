<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function index(Request $request){
        try {
            $countries = Country::select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')->when($request->keyword, function($query) use ($request){
                $query->where('name', 'like', $request->keyword . '%')
                      ->orWhere('code', 'like', $request->keyword . '%');
            })
            ->join('regions', 'countries.region_id', '=', 'regions.id')
            ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
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
    public function nationalGroupByRegion(Request $request){

        $data = array();
        $data[0]['name'] = 'Europe';
        $data[0]['name_vi'] = 'Châu Âu';
        $europe = DB::table('countries')
        ->select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
        ->where('countries.region_id', '4')
        ->orderBy('countries.name')
        ->get();
        $data[0]['items'] = $europe;
        $data[1]['name'] = 'Africa';
        $data[1]['name_vi'] = 'Châu Phi';
        $africa = DB::table('countries')
        ->select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
        ->where('countries.region_id', '1')
        ->orderBy('countries.name')
        ->get();
        $data[1]['items'] = $africa;
        $data[2]['name'] = 'Asia';
        $data[2]['name_vi'] = 'Châu Á';
        $asia = DB::table('countries')
        ->select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
        ->where('countries.region_id', '3')
        ->orderBy('countries.name')
        ->get();
        $data[2]['items'] = $asia;
        $data[3]['name'] = 'Oceania';
        $data[3]['name_vi'] = 'Châu Đại Dương';
        $oceania = DB::table('countries')
        ->select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
        ->where('countries.region_id', '5')
        ->orderBy('countries.name')
        ->get();
        $data[3]['items'] = $oceania;
        $data[4]['name'] = 'Northern & Central America';
        $data[4]['name_vi'] = 'Bắc & Trung Mỹ';
        $nca = DB::table('countries')
        ->select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
        ->whereIn('countries.subregion_id', array(6,9))
        ->orderBy('countries.name')
        ->get();
        $data[4]['items'] = $nca;
        $data[5]['name'] = 'South America';
        $data[5]['name_vi'] = 'Nam Mỹ';
        $sa = DB::table('countries')
        ->select('countries.*', 'regions.name_vi as region_vi', 'subregions.name_vi as subregion_vi')
        ->join('regions', 'countries.region_id', '=', 'regions.id')
        ->join('subregions', 'countries.subregion_id', '=', 'subregions.id')
        ->whereIn('countries.subregion_id', array(8))
        ->orderBy('countries.name')
        ->get();
        $data[5]['items'] = $sa;
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    public function listRegions(){
        $regions = DB::table('regions')->get();
        $data = [];
        foreach ($regions as $k=>$region){
            $data[$k]['item'] = $region;
            $data[$k]['subs'] = DB::table('subregions')->where('region_id',$region->id)->get();
        }
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
