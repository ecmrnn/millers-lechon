<?php

namespace Database\Seeders;

use App\Models\Address\City;
use App\Models\Address\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        try {
            foreach($cities as $city) {
                $psgc_id = $city->psgc_id;
                $requestUri = "https://psgc.cloud/api/v2/provinces/$psgc_id/municipalities";

                $municipalities = Http::get($requestUri);

                if ($municipalities) {
                    foreach ($municipalities->json()['data'] as $municipality) {
                        $city->municipalities()->create([
                            'psgc_id' => $municipality['code'],
                            'name' => $municipality['name'],
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
