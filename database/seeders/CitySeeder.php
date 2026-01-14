<?php

namespace Database\Seeders;

use App\Models\Address\City;
use App\Models\Address\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Throwable;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = Region::all();

        foreach ($regions as $region) {
            $psgc_id = $region->psgc_id;

            try {
                $requestUri = "https://psgc.cloud/api/regions/$psgc_id/provinces";
    
                if ($region && $region->name === 'National Capital Region (NCR)')
                {
                    $requestUri = "https://psgc.cloud/api/regions/$psgc_id/cities";
                }
                
                $provinces = Http::get($requestUri);
    
                if ($provinces) {
                    foreach ($provinces->json() as $province) {
                        $region->cities()->create([
                            'psgc_id' => $province['code'],
                            'name' => $province['name']
                        ]);
                    }
                }
            }
            catch( Throwable $th)
            {
                //
            }
        }
    }
}
