<?php

namespace Database\Seeders;

use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
    DB::table('departments')->insert(
      [
        'name' => 'Teknik Informatika',
        'head_of_department' => 'Untung Suprihadi',
      ]
    );

    // Menggunakan GuzzleHttp\Client untuk mengunduh gambar
    $client = new Client();

    $response = $client->get("https://ui-avatars.com/api/?name=Admin Siperu&background=A5A6FF&bold=true&color=FFF&length=2");
    $avatarFileName = time() . '.png'; // Generate nama unik untuk file avatar (misalnya, menggunakan timestamp)
    $avatarPath = public_path('avatars/' . $avatarFileName); // Tentukan path lengkap untuk menyimpan file avatar

    // Simpan file avatar ke dalam folder "public/avatars"
    file_put_contents($avatarPath, $response->getBody());

    DB::table('users')->insert(
      [
        'fullname' => 'Admin Siperu',
        'slug' => 'admin-siperu',
        'email' => 'admin@gmail.com',
        'phone_number' => '081314697305',
        'password' => bcrypt('123123'),
        'role' => 'admin',
        'avatar' => 'avatars/' . $avatarFileName
      ],
    );

    DB::table('users')->insert(
      [
        'fullname' => 'Ananda Rizq',
        'slug' => 'ananda-rizq',
        'email' => 'anndrzq32@gmail.com',
        'phone_number' => '12313213132',
        'department_id' => '1',
        'password' => bcrypt('123123'),
        'role' => 'head_baak',
        'avatar' => 'avatars/' . $avatarFileName
      ],
    );

    DB::table('users')->insert(
      [
        'fullname' => 'Ananda',
        'slug' => 'ananda',
        'email' => 'anndrzq8@gmail.com',
        'phone_number' => '12313213132',
        'department_id' => '1',
        'password' => bcrypt('123123'),
        'role' => 'user',
        'avatar' => 'avatars/' . $avatarFileName
      ],
    );
  }
}
