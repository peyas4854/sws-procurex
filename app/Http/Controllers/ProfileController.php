<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'exist_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!(Hash::check($request->get('exist_password'), Auth::user()->password))) {
            $message = message("Your current password does not matches with the password you provided. Please try again.","error");
            session()->flash("message", $message);
            return redirect()->back();

        }
        if(strcmp($request->get('exist_password'), $request->get('password')) == 0){
            //Current password and new password are same
            $message = message("New Password cannot be same as your current password. Please choose a different password.","error");
            session()->flash("message", $message);
            return redirect()->back();
        }
        $user = Auth::user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        Auth::logout();
        session()->invalidate();
        $message = message("Your password has been changed.Login with new password");
        session()->flash("message", $message);
        return redirect("login");

    }

}
