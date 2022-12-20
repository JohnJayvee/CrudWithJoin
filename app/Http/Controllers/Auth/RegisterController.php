<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register()
    {

        return view('auth.register');
    }

    public function storeUser(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ],
            [
                'name.required' => 'Enter a valid :attribute is required',
                'email.required' => 'Enter a valid :attribute is required',
                'password.required' => 'Enter a valid :attribute is required',
                'password_confirmation.required' => 'Enter a valid confirm password is required',
                'password.confirmed' => 'The confirm password does not match.',

            ]
        );

        $debug = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0
        ]);

        return redirect()->route('auth.login');
    }
}
