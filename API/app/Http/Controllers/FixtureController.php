<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixturesByTeamRequest;
use App\Models\Fixture;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixtureController extends Controller
{
    public function index(GetFixturesByTeamRequest $request){
        $team = Team::where('slug', $request->team_slug)->first();
        if(!$team){
            $country = DB::table('countries')->where('slug',$request->team_slug)->select('name')->first();
            $team = Team::where('country', $country->name)->where('national',1)->first();
        }
        $fixtures = Fixture::where(function($query) use ($team){
            if($team->api_id){
                $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$team->api_id])
                ->orWhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$team->api_id]);
            }
        })
        // if type = 1 then get schedule
        ->when($request->type == 1, function($query) use ($request){
            $query->whereDate('date', '>=', Carbon::today());
        })
        // if type = 0 then get results
        ->when($request->type == 0, function($query){
            $query->whereDate('date', '<=', Carbon::today())
                  ->limit(10);
        })
        ->paginate($request->per_page);

        return response()->json([
            'status' => true,
            'data' => $fixtures,
        ]);
    }
}
