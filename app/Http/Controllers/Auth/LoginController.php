<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'keyword' => 'required',
            'password' => 'required'
        ], [
            'keyword.required' => 'Masukan email atau username anda',
            'password.required' => 'Masukan password anda'
        ]);

        $user = User::where('email', $request->keyword)->orWhere('username', $request->keyword)->first();
        $isEmail = filter_var($request->keyword, FILTER_VALIDATE_EMAIL);

        if ( $user ) {
            if ( Hash::check($request->password, $user->password) ) {
                Auth::attempt([
                    $isEmail ? 'email' : 'username' => $request->keyword,
                    'password' => $request->password
                ]);
                return redirect('home');
            }
            return redirect('login')->withErrors(['password' => 'Password tidak tepat'])->withInput($request->except('password'));
        }
        return redirect('login')->withErrors(['keyword' => 'Email atau username tidak ditemukan'])->withInput($request->except('password'));
    }
}
