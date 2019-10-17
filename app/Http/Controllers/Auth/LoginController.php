<?php

namespace Autobot\Http\Controllers\Auth;

use Autobot\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    public function showLoginForm()
    {
        return view('default.login');
    }

    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|exists:ab_users,' . $this->username() . ',status,1', 'password' => 'required',
        ], [
            $this->username() . '.exists' => 'These credentials do not match our records or account has been disabled.'
        ]);
    }

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
}
