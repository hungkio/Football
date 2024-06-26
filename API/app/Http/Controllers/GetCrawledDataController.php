<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixturesRequest;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetCrawledDataController extends Controller
{
    public function getFixtures(GetFixturesRequest $request){
        $date = $request->date;
        $fixtures = Fixture::where('fixture->date','like', $date.'%')->get();
        $arr = [];
        foreach ($fixtures as $fixture) {
            $leagueName = $fixture->league['name'];
            $arr[$leagueName][] = $fixture->toArray();
        }
        return response()->json($arr);
    }

    public function getLiveFixtures(){
        $fixtures = Fixture::all();
        $arr = [];
        foreach ($fixtures as $fixture) {
            $leagueName = $fixture->league['name'];
            $arr[$leagueName][] = $fixture->toArray();
        }
        return response()->json($arr);
    }
}
