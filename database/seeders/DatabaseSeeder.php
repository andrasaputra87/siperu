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

    DB::table('departments')->insert(
      [
        'name' => 'Teknik Sipil',
        'head_of_department' => 'Siapa',
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
        'fullname' => 'ade chandra',
        'slug' => 'ade-chandra',
        'email' => 'ade.chandra.saputra.tumbai@gmail.com',
        'phone_number' => '081314697305',
        'password' => bcrypt('1234567890'),
        'role' => 'admin',
        'avatar' => 'avatars/' . $avatarFileName,
        'signature' => 'signature/654dc1d4473c7.png',
        'nim' => '193011111111'
      ],
    );

    DB::table('users')->insert(
      [
        'fullname' => 'ade chandra',
        'slug' => 'ade-chandra-2',
        'email' => 'adechandra@it.upr.ac.id',
        'phone_number' => '12313213132',
<<<<<<< HEAD
        'department_id' => '1',
=======
        'department_id' => '2',
>>>>>>> c317f37939c39835a93fb37115347e4164dd1793
        'password' => bcrypt('1234567890'),
        'role' => 'head_baak',
        'avatar' => 'avatars/' . $avatarFileName
      ],
    );
  }
}
