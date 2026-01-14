<?php

namespace Database\Seeders;

use App\Models\Address\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $regions = Http::get('https://psgc.cloud/api/v2/regions');
    
            if ($regions) {
                foreach ($regions->json()['data'] as $region) {
                    Region::create([
                        'psgc_id' => $region['code'],
                        'name' => $region['name'],
                        'is_active' => true
                    ]);
                }
            }
        } catch (\Throwable $th) {
            // 
        }
    }
}
