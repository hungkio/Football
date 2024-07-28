<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Domain\Country\Models\Country;

class UpdateCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = json_decode(file_get_contents('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries.json'), true);
        foreach($json as $key => $item){
            $code = $item['iso2'];
            $region = $item['region'];
            $region_id = $item['region_id'];
            $subregion = $item['subregion'];
            $subregion_id = $item['subregion_id'];
            Country::where('code', $code)->update(['region'=>$region, 'region_id'=>$region_id, 'subregion'=>$subregion, 'subregion_id'=>$subregion_id]);
        }
    }
}
