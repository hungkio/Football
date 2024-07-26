<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTeamsRequest;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(GetTeamsRequest $request){
        try {
            $teams = Team::when(isset($request->keyword), function($query) use ($request){
                $query->where('name','like', $request->keyword . '%')
                      ->orWhere('api_id', 'like', $request->keyword . '%');
            })
            ->when(isset($request->national), function($query) use ($request){
                $query->where('national', $request->national);
            })
            ->paginate($request->per_page);
            return response()->json([
                'status' => true,
                'data' => $teams
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }
}
