<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function autocomment()
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.auto-comment', ['accounts' => $accounts]);
        } else {
            return view('default.auto-comment');
        }
    }

    public function autocommentdata($username)
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_autocomment_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('auto-comment');
        }
        $userlock = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $groups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'comment')->get();
        $blacklistgroups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'blacklist')->get();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.auto-comment', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => $user->target, 'timelinefeed' => $user->timelinefeed, 'blacklistgroups' => $blacklistgroups, 'commentgroup' => $user->commentgroup, 'blacklist' => $user->blacklist, 'speed' => $user->speed, 'status' => $user->status, 'groups' => $groups]);
            } else {
                return redirect('auto-comment');
            }
        }else{
            return view('default.auto-comment', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'target' => "", 'timelinefeed' => "", 'blacklistgroups' => $blacklistgroups, 'commentgroup' => "", 'blacklist' => "", 'speed' => "", 'status' => "", 'groups' => $groups]);
        }
    }

    public function updatecomment(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $target = $request->input('target');
        $timelinefeed = $request->input('timelinefeed') ? 1 : 0;
        $commentgroup = $request->input('commentgroup');
        $blacklist = $request->input('blacklist');
        $speed = $request->input('speed');
        $status = $request->input('status');
        $query = DB::table('ab_autocomment_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($query == NULL) {
            DB::table('ab_autocomment_data')->insert(
                    ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'target' => $target, 'timelinefeed' => $timelinefeed, 'commentgroup' => $commentgroup, 'blacklist' => $blacklist, 'speed' => $speed, 'status' => $status]
                        );
        }else{
            DB::table('ab_autocomment_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => $target, 'timelinefeed' => $timelinefeed, 'commentgroup' => $commentgroup, 'blacklist' => $blacklist, 'speed' => $speed, 'status' => $status]);
        }
        return redirect('auto-comment/'.$username.'?ok');
    }
}