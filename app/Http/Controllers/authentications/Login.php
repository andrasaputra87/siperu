<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
  public function index()
  {
    return view('content.authentications.login');
  }

  public function auth(Request $request)
  {
    $credentials = $request->validate([ 
      // |email:dns
      'email' => 'required',
      'password' => 'required',
    ]);

    $remember = $request->filled('remember'); // Mengambil nilai remember dari checkbox

    if (Auth::attempt($credentials, $remember)) {
      $request->session()->regenerate();

      return redirect()->intended('dashboard')->with('message', 'Berhasil masuk. Nikmati langganan kami!👋');
    }

    return back()->with('message_error', 'Data yang diberikan tidak sesuai dengan data kami.');
  }
}
