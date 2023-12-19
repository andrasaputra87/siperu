<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert(
            [
              'name' => 'Teknik Sipil',
              'head_of_department' => 'Siapa',
              'faculty_id' => 1,
            ]
        );

        DB::table('departments')->insert(
            [
              'name' => 'Teknik Informatika',
              'head_of_department' => 'Untung Suprihadi',
              'faculty_id' => 1,
            ]
          );
    }
}
