<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class Register extends Controller
{
  public function index()
  {
    return view('content.authentications.register', [
      'departments' => Department::orderBy('id', 'desc')->get()
    ]);
  }

  public function registration(Request $request) {
    $data = $request->validate([
      'fullname' => 'required',
      'email' => 'required|email:dns|unique:users',
      'nim' => 'required|unique:users',
      'department_id' => 'required',
      'phone_number' => 'required',
      'password' => 'required|min:6|confirmed',
      'password_confirmation' => 'required',
    ]);

    // Menggunakan GuzzleHttp\Client untuk mengunduh gambar
    $client = new Client();

    $response = $client->get("https://ui-avatars.com/api/?name=" . urlencode($data["fullname"]) . "&background=A5A6FF&bold=true&color=FFF&length=2");
    $avatarFileName = time() . '.png'; // Generate nama unik untuk file avatar (misalnya, menggunakan timestamp)
    $avatarPath = public_path('avatars/' . $avatarFileName); // Tentukan path lengkap untuk menyimpan file avatar

    // Simpan file avatar ke dalam folder "public/avatars"
    file_put_contents($avatarPath, $response->getBody());

    // Simpan nama file avatar ke dalam data pengguna
    $data["avatar"] = 'avatars/' . $avatarFileName;

    $data['password'] = bcrypt($data['password']); // Mengenkripsi password sebelum menyimpannya

    $user = User::create($data);

    $rememberToken = Hash::make($user->id);
    $user->forceFill([
        'remember_token' => $rememberToken,
    ])->save();

    return redirect('/')->with('message_success', 'Berhasil mendaftar. Silahkan masuk!👋');
  }
}
