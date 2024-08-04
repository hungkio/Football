<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStandingByLeagueRequest;
use App\Models\League;
use App\Models\Standing;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    function index(GetStandingByLeagueRequest $request) {
        $league = League::where('slug', $request->league_slug)->first();
        $standings = Standing::where('league_id', $league->api_id)
        ->where('season', $request->season)
        ->paginate($request->per_page);
        foreach ($standings as $standing) {
            $team = Team::where('api_id', $standing->team_id)->first();
            $standing->team_name = $team ? $team->name : '';
        }
        return response()->json($standings);
    }
}
