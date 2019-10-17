<?php

namespace Autobot\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;

class HomeController extends Controller
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

    public function home()
    {
        $user_id  = Auth::id();
        $photos   = DB::table('ab_photos')->where('user_id', $user_id)->where('username', NULL)->orderBy('id', 'desc')->paginate(12);
        $photocheck = DB::table('ab_photos')->where('user_id', $user_id)->where('username', NULL)->first();
        $accounts = DB::table('ab_accounts')->where('user_id', $user_id)->get();
        $accountcheck = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        
        return view('default.index', ['user_id' => $user_id, 'photos' => $photos, 'photocheck' => $photocheck, 'accounts' => $accounts, 'accountcheck' => $accountcheck]);
    }
}
