<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert data ke table rooms
        DB::table('rooms')->insert([
        	'name' => 'GEDUNG MERAH PUTIH',
        	'description' => 'Gedung merah putih memiliki : lorem ipsum',
        	'thumbnail' => 'room_images/1699498070_sosialiasasi.jpg',
        	'capacity' => 50,
        	'location' => 'Lantai 1',
        	'availability' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        	'building_id' => 1
        ]);
    }
}
