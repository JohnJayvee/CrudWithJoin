<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login()
    {

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate(
            [
                'login' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'login.required' => 'Enter a valid username or email is required',
                'password.required' => 'Enter a valid :attribute is required'
            ]
        );
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('login')
        ]);

        $credentials = $request->only(
            $login_type,
            'password'
        );


        if (Auth::attempt($credentials)) {
            // return redirect()->intended('home');
            if (auth()->user()->is_admin == 1) {

                return redirect()->route('admin.home');
            } else {
                return redirect()->route('home');
            }
        }

        return redirect('login')
            ->with('error', 'These credentials do not match our records.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
