<?php

namespace App\Http\Controllers\authentications;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPassword extends Controller
{
  public function index()
  {
    return view('content.authentications.forgot-password');
  }

  public function action(Request $request)
  {
    $request->validate([
      'email' => 'required|email:dns'
    ]);

    $status = Password::sendResetLink(
      $request->only('email')
    );

    return $status == Password::RESET_LINK_SENT ? back()->with(['status' => __($status)]) : back()->withErrors(['status' => __($status)]);
  }

  public function reset_password(string $token) 
  {
    return view('content.authentications.reset-password', ['token' => $token]);
  }

  public function reset_password_action(Request $request) 
  {
    $request->validate([
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function (User $user, string $password) {
          $user->forceFill([
              'password' => Hash::make($password)
          ])->setRememberToken(Str::random(60));

          $user->save();

          event(new PasswordReset($user));
      }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect('/')->with('message_success', __($status))
                : back()->withErrors(['email' => [__($status)]]);
  }

}
