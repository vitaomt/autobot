<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RepostController extends Controller
{
    public function autorepost()
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.auto-repost', ['accounts' => $accounts]);
        } else {
            return view('default.auto-repost');
        }
    }

    public function autorepostdata($username)
    {
        $user_id  = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $data     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('auto-repost');
        }
        $userlock = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $groups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'caption')->get();
        $blacklistgroups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'blacklist')->get();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.auto-repost', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => $user->target, 'groups' => $groups, 'captiongroup' => $user->captiongroup, 'blacklistgroups' => $blacklistgroups, 'caption' => $user->caption, 'blacklist' => $user->blacklistgroup, 'speed' => $user->speed, 'status' => $user->status]);
            } else {
                return redirect('auto-repost');
            }
        }else{
            return view('default.auto-repost', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => "", 'groups' => $groups, 'captiongroup' => "", 'blacklistgroups' => $blacklistgroups, 'caption' => "", 'blacklist' => "", 'speed' => "", 'status' => ""]);
        }
    }

    public function updaterepost(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $target = $request->input('target');
        $captiongroup = $request->input('captiongroup');
        $blacklistgroup = $request->input('blacklistgroup');
        $speed = $request->input('speed');
        $status = $request->input('status');
        $query = DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();

        if ($query == NULL) {
            if ($captiongroup == "newcaption") {
                $caption = $request->input('caption');

                DB::table('ab_autorepost_data')->insert(
                        ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'target' => $target, 'captiongroup' => NULL, 'caption' => $caption, 'blacklistgroup' => $blacklistgroup, 'speed' => $speed, 'status' => $status]
                            );
            }else{
                DB::table('ab_autorepost_data')->insert(
                        ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'target' => $target, 'captiongroup' => $captiongroup, 'caption' => NULL, 'blacklistgroup' => $blacklistgroup, 'speed' => $speed, 'status' => $status]
                            );
            }
        }else{
            if ($captiongroup == "newcaption") {
                $caption = $request->input('caption');

                DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => $target, 'captiongroup' => NULL, 'caption' => $caption, 'blacklistgroup' => $blacklistgroup, 'speed' => $speed, 'status' => $status]);
            }else{
                DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => $target, 'captiongroup' => $captiongroup, 'caption' => NULL, 'blacklistgroup' => $blacklistgroup, 'speed' => $speed, 'status' => $status]);
            }
        }
        return redirect('auto-repost/'.$username.'?ok');
    }
}