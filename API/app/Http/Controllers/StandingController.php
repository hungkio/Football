<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStandingByLeagueRequest;
use App\Models\League;
use App\Models\Standing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    function index(GetStandingByLeagueRequest $request) {
        $league = League::where('slug', $request->league_slug)->first();
        $standings = Standing::where('league_id', $league->api_id)
        ->where('season', $request->season)
        ->paginate($request->per_page);
        return response()->json($standings);
    }
}
