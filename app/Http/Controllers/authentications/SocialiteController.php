<?php

namespace App\Http\Controllers\authentications;

use Exception;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

  public function redirectToProvider($provider)
  {
      return Socialite::driver($provider)->redirect();
  }

  public function handleProviderCallback($provider)
  {
      try {
        $user = Socialite::driver($provider)->user();
        // dd($user->getAvatar());
      } catch (Exception $e) {
        return redirect('/');
      }

      $auth_user = $this->findOrCreateUser($user, $provider);

      Auth::login($auth_user, true);

      return redirect('/dashboard')->with('message', 'Berhasil masuk. Nikmati langganan kami!👋');
  }

  public function findOrCreateUser($socialUser, $provider)
  {
      $social_account = SocialAccount::where('provider_id', $socialUser->getId())->where('provider_name', $provider)->first();

      if ($social_account) {

        return $social_account->user;

      } else {

        $user = User::where('email', $socialUser->getEmail())->first();

        if(!$user) {
          // Menggunakan GuzzleHttp\Client untuk mengunduh gambar
          $client = new Client();

          $response = $client->get("https://ui-avatars.com/api/?name=" . urlencode($socialUser->getName()) . "&background=A5A6FF&bold=true&color=FFF&length=2");
          $avatarFileName = time() . '.png'; // Generate nama unik untuk file avatar (misalnya, menggunakan timestamp)
          $avatarPath = public_path('avatars/' . $avatarFileName); // Tentukan path lengkap untuk menyimpan file avatar

          // Simpan file avatar ke dalam folder "public/avatars"
          file_put_contents($avatarPath, $response->getBody());

          $user = User::create([
            'fullname' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'avatar' => 'avatars/' . $avatarFileName
          ]);


        }

        $user->social_accounts()->create([
          'provider_id' => $socialUser->getId(),
          'provider_name' => $provider
        ]);

        return $user;

      }
  }

}
