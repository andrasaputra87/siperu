<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buildings')->insert(
            [
              'id' => 1,
              'building_name' => 'Merah Putih',
              'checkfloor' => 1,
              'floor' => 0,
              'thumbnail' => 'building_images/1704770421_Universitas-Palangkaraya-Logo.png'
            ]
        );
    }
}
