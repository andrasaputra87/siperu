<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faculties')->insert(
            [
                'id' => 1,
                'name' => 'Teknik',
                'dekan' => 'Andika',
            ]
        );

        DB::table('faculties')->insert(
            [
                'id' => 2,
                'name' => 'FKIP',
                'dekan' => 'Bunga',
            ]
        );
    }
}
