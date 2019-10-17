<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UnfollowController extends Controller
{
    public function autounfollow()
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.auto-unfollow', ['accounts' => $accounts]);
        } else {
            return view('default.auto-unfollow');
        }
    }

    public function autounfollowdata($username)
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_autounfollow_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('auto-unfollow');
        }
        $userlock     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.auto-unfollow', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'dontunfollow' => $user->dontunfollow, 'dontunfollowpp' => $user->dontunfollowpp, 'botdetect' => $user->botdetect, 'botdetect2' => $user->botdetect2, 'whitelist' => $user->whitelist, 'speed' => $user->speed, 'status' => $user->status]);
            } else {
                return redirect('auto-unfollow');
            }
        }else{
            return view('default.auto-unfollow', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'dontunfollow' => "", 'dontunfollowpp' => "", 'botdetect' => "", 'botdetect2' => "", 'whitelist' => "", 'speed' => "", 'status' => ""]);
        }
    }

    public function updateunfollow(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $dontunfollow = $request->input('dontunfollow') ? 1 : 0;
        $dontunfollowpp = $request->input('dontunfollowpp') ? 1 : 0;
        $botdetect = $request->input('botdetect');
        $botdetect2 = $request->input('botdetect2');
        $whitelist = $request->input('whitelist');
        $speed = $request->input('speed');
        $status = $request->input('status');
        $query = DB::table('ab_autounfollow_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($query == NULL) {
            DB::table('ab_autounfollow_data')->insert(
                    ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'dontunfollow' => $dontunfollow, 'dontunfollowpp' => $dontunfollowpp, 'botdetect' => $botdetect, 'botdetect2' => $botdetect2, 'whitelist' => $whitelist, 'speed' => $speed, 'status' => $status]
                        );
        }else{
            DB::table('ab_autounfollow_data')->where('user_id', $user_id)->where('username', $username)->update(['dontunfollow' => $dontunfollow, 'dontunfollowpp' => $dontunfollowpp, 'botdetect' => $botdetect, 'botdetect2' => $botdetect2, 'whitelist' => $whitelist, 'speed' => $speed, 'status' => $status]);
        }
        return redirect('auto-unfollow/'.$username.'?ok');
    }
}