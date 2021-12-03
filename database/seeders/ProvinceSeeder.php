<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Province::truncate();
        $provinces = [
            ['id'=>5, 'name'=>'EASTERN'],
            ['id'=>1, 'name'=>'KIGALI'],
            ['id'=>4, 'name'=>'NORTHERN'],
            ['id'=>2, 'name'=>'SOUTHERN'],
            ['id'=>3, 'name'=>'WESTERN']
        ];
        Province::insert($provinces);
    }
}
