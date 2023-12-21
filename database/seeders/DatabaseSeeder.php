<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {

    $this->call([
      TahunAjaranSeeder::class,
      FacultySeeder::class,
      DepartmentSeeder::class,
      UserSeeder::Class,
      RoomSeeder::class,
      RoomReservationSeeder::class,
      RoomImageSeeder::class,
  ]);
  }
}
