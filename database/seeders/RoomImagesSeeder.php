<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
        	'name' => 'GEDUNG MERAH PUTIH',
        	'description' => 'Gedung merah putih memiliki : lorem ipsum',
        	'thumbnail' => 'room_images/1699498070_sosialiasasi.jpg',
        	'capacity' => 50,
        	'location' => 'Lantai 1',
        	'availability' => 1,
        	'created_at' => '2023-11-09 02:47:50',
        	'updated_at' => '2023-11-09 02:47:50',
        	'ownership' => 'BAAK'
        ]);
    }
}
