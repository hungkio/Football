<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixturesByTeamRequest;
use App\Models\Fixture;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixtureController extends Controller
{
    public function index(GetFixturesByTeamRequest $request){
        $fixtures = Fixture::where(function($query) use ($request){
            $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$request->team_id])
                ->orWhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$request->team_id]);
        })
            ->when($request->type, function($query) use ($request){
                $query->where('date' ,'>=', Carbon::now());
            })
            ->when(!$request->type, function($query) use ($request){
                $query->where('date', '<=', Carbon::now());
            })
            ->paginate($request->per_page);
        return response()->json([
            'status' => true,
            'data' => $fixtures,
        ]);
    }
}
