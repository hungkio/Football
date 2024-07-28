<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = json_decode(file_get_contents('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/regions.json'), true);
        foreach($regions as $region){
            $id = $region['id'];
            $name = $region['name'];
            $name_vi = $region['name'];
            $slug = Str::slug($name);
            DB::table('regions')->insert(['id'=> $id, 'name' => $name , 'name_vi' => $name_vi, 'slug'=>$slug]);
        }
        $subregions = json_decode(file_get_contents('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/subregions.json'), true);
        foreach($subregions as $sregion){
            $id = $sregion['id'];
            $name = $sregion['name'];
            $name_vi = $sregion['name'];
            $region_id = $sregion['region_id'];
            $slug = Str::slug($name);
            DB::table('subregions')->insert(['id'=> $id, 'name' => $name , 'name_vi' => $name_vi, 'slug'=>$slug, 'region_id' => $region_id]);
        }
    }
}
