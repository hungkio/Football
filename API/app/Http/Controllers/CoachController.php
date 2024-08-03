<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(){
        try {
            $coaches = Coach::all();
            return response()->json([
                'status' => true,
                'data' => $coaches,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ]);
        }
    }

    public function details($coach){
        try {
            $coach = Coach::find($coach);
            return response()->json($coach);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th,
            ]);
        }
    }
}
