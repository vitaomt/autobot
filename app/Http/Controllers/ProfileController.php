<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
    	$user_id = Auth::id();
        $profile = DB::table('ab_users')->where('id', $user_id)->first();
        
        return view('default.profile', ['name' => $profile->name, 'email' => $profile->email, 'registerdate' => $profile->created_at]);
    }

    public function updatesettings(Request $request)
    {
        $user_id = Auth::id();
        $name = $request->input('name');
        
        DB::table('ab_users')->where('id', $user_id)->update(['name' => $name]);

        return redirect('profile?ok');
    }
}