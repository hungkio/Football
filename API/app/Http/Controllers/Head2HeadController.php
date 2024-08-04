<?php

namespace App\Http\Controllers;

use App\Http\Requests\Head2HeadRequest;
use App\Models\Fixture;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Head2HeadController extends Controller
{
    public function index(Head2HeadRequest $request){
        Artisan::call('app:crawl-head2-head-data', [
            'h2h' => $request->h2h,
        ]);
        list($teamId1, $teamId2) = explode('-', $request->h2h);
        $teamId1 = (int) $teamId1; 
        $teamId2 = (int) $teamId2; 
        $fixtures = Fixture::where(function($query) use ($teamId1, $teamId2){
            $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$teamId1])
            ->WhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$teamId2]);
        })
        ->orWhere(function($query) use ($teamId1, $teamId2){
            $query->whereRaw("JSON_EXTRACT(teams, '$.home.id') = ?", [$teamId2])
            ->WhereRaw("JSON_EXTRACT(teams, '$.away.id') = ?", [$teamId1]);
        })->paginate($request->per_page);

        return response()->json($fixtures);
    }
}
