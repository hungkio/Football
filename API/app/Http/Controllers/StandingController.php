<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetStandingByLeagueRequest;
use App\Models\Standing;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    function index(Request $request) {
        $standings = Standing::where('league_id', 4)
        ->where('season', Carbon::now()->format('Y'))
        ->paginate($request->per_page);
        $arr = [];
        foreach ($standings as $standing) {
            $group = $standing->group;
            $arr[$group][] = $standing->toArray();
        }
        $collection = collect($arr);
        return response()->json([
            'status' => true,
            'data' => $collection
        ]);
    }
}
