<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetFixturesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetCrawledDataController extends Controller
{
    public function getFixtures(GetFixturesRequest $request){
        $date = $request->date;
        $filePath = 'Crawl/database/crawls/' . $date . '-fixture.json';
        
        if (Storage::exists($filePath)) {
            dd('run here');
            $contents = Storage::get($filePath);

            $data = json_decode($contents, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}
