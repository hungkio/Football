<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index(){
        try {
            $leagues = League::all();
            return response()->json([
                'status' => true,
                'data' => $leagues
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th
            ]);
        }
    }
}
