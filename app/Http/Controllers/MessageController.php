<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function automessage()
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.auto-message', ['accounts' => $accounts]);
        } else {
            return view('default.auto-message');
        }
    }

    public function automessagedata($username)
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_automessage_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('auto-message');
        }
        $userlock     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $blacklistgroups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'blacklist')->get();
        $captiongroups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'caption')->get();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.auto-message', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => $user->target, 'tofollowers' => $user->tofollowers, 'tofollowings' => $user->tofollowings, 'accountphoto' => $user->accountphoto, 'accountstatus' => $user->accountstatus, 'botdetect' => $user->botdetect, 'botdetect2' => $user->botdetect2, 'blacklistgroups' => $blacklistgroups, 'captiongroups' => $captiongroups, 'captiongroup' => $user->captiongroup, 'blacklist' => $user->blacklist, 'speed' => $user->speed, 'status' => $user->status]);
            } else {
                return redirect('auto-message');
            }
        }else{
            return view('default.auto-message', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => "", 'tofollowers' => "", 'tofollowings' => "", 'accountphoto' => "", 'accountstatus' => "", 'botdetect' => "", 'botdetect2' => "", 'captiongroups' => $captiongroups, 'captiongroup' => "", 'blacklistgroups' => $blacklistgroups, 'blacklist' => "", 'speed' => "", 'status' => ""]);
        }
    }

    public function updatemessage(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $target = $request->input('target');
        $tofollowers = $request->input('tofollowers') ? 1 : 0;
        $tofollowings = $request->input('tofollowings') ? 1 : 0;
        $accountphoto = $request->input('accountphoto');
        $accountstatus = $request->input('accountstatus');
        $botdetect = $request->input('botdetect');
        $botdetect2 = $request->input('botdetect2');
        $captiongroup = $request->input('captiongroup');
        $blacklist = $request->input('blacklist');
        $speed = $request->input('speed');
        $status = $request->input('status');
        $query = DB::table('ab_automessage_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($query == NULL) {
            DB::table('ab_automessage_data')->insert(
                    ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'target' => $target,'tofollowers' => $tofollowers, 'tofollowings' => $tofollowings, 'accountphoto' => $accountphoto, 'accountstatus' => $accountstatus, 'botdetect' => $botdetect, 'botdetect2' => $botdetect2, 'captiongroup' => $captiongroup, 'blacklist' => $blacklist, 'speed' => $speed, 'status' => $status]
                        );
        }else{
            DB::table('ab_automessage_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => $target, 'tofollowers' => $tofollowers, 'tofollowings' => $tofollowings, 'accountphoto' => $accountphoto, 'accountstatus' => $accountstatus, 'botdetect' => $botdetect, 'botdetect2' => $botdetect2, 'captiongroup' => $captiongroup, 'blacklist' => $blacklist, 'speed' => $speed, 'status' => $status]);
        }
        return redirect('auto-message/'.$username.'?ok');
    }
}