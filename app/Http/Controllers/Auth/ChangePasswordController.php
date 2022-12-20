<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    public function index()
    {

        return view('auth.changepassword');
    }

    public function storeNewPassword(Request $request)
    {
        $request->validate(
            [
                'current_password' => 'required',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ],
            //*Custom Validation Message
            [
                'current_password.required' => 'Enter a valid :attribute is required',
                'password.required' => 'Enter a valid :attribute is required',
                'password.confirmed' => 'The confirm password does not match.',
                'password_confirmation.required' => 'Enter a valid confirm password is required  '
            ]
        );

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Password successfully changed!');
    }
}
