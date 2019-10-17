<?php

namespace Autobot\Http\Controllers;

use Auth;
use Hash;
use DB;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|max:100|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user_id = Auth::id();
        $password = bcrypt($request->get('new-password'));
        DB::table('ab_users')->where('id', $user_id)->update(['password' => $password]);
        return redirect()->back()->with("success","Password changed successfully !");
    }
}
