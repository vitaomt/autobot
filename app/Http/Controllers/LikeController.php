<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function autolike()
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.auto-like', ['accounts' => $accounts]);
        } else {
            return view('default.auto-like');
        }
    }

    public function autolikedata($username)
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_autolike_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('auto-like');
        }
        $userlock     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $blacklistgroups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'blacklist')->get();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.auto-like', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => $user->target, 'timelinefeed' => $user->timelinefeed, 'blacklistgroups' => $blacklistgroups, 'blacklist' => $user->blacklist, 'speed' => $user->speed, 'status' => $user->status]);
            } else {
                return redirect('auto-like');
            }
        }else{
            return view('default.auto-like', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => "", 'timelinefeed' => "", 'blacklistgroups' => $blacklistgroups, 'blacklist' => "", 'speed' => "", 'status' => ""]);
        }
    }

    public function updatelike(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $target = $request->input('target');
        $timelinefeed = $request->input('timelinefeed') ? 1 : 0;
        $blacklist = $request->input('blacklist');
        $speed = $request->input('speed');
        $status = $request->input('status');
        $query = DB::table('ab_autolike_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($query == NULL) {
            DB::table('ab_autolike_data')->insert(
                    ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'target' => $target, 'timelinefeed' => $timelinefeed, 'blacklist' => $blacklist, 'speed' => $speed, 'status' => $status]
                        );
        }else{
            DB::table('ab_autolike_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => $target, 'timelinefeed' => $timelinefeed, 'blacklist' => $blacklist, 'speed' => $speed, 'status' => $status]);
        }
        return redirect('auto-like/'.$username.'?ok');
    }
}