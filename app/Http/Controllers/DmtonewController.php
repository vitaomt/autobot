<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DmtonewController extends Controller
{
    public function autodmtonew()
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.auto-dmtonew', ['accounts' => $accounts]);
        } else {
            return view('default.auto-dmtonew');
        }
    }

    public function autodmtonewdata($username)
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_autodmtonew_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('auto-dmtonew');
        }
        $userlock     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $captiongroups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'caption')->get();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.auto-dmtonew', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'captiongroups' => $captiongroups, 'caption' => $user->caption, 'status' => $user->status]);
            } else {
                return redirect('auto-dmtonew');
            }
        }else{
            return view('default.auto-dmtonew', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'photo' => $data->profilepic, 'about' => $data->about, 'private' => $data->private, 'mediacount' => $data->mediacount, 'followercount' => $data->followercount, 'followingcount' => $data->followingcount, 'captiongroups' => $captiongroups, 'caption' => "", 'status' => ""]);
        }
    }

    public function updatedmtonew(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $caption = $request->input('caption');
        $status = $request->input('status');
        $query = DB::table('ab_autodmtonew_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($query == NULL) {
            DB::table('ab_autodmtonew_data')->insert(
                    ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'caption' => $caption, 'status' => $status]
                        );
        }else{
            DB::table('ab_autodmtonew_data')->where('user_id', $user_id)->where('username', $username)->update(['caption' => $caption, 'status' => $status]);
        }
        return redirect('auto-dmtonew/'.$username.'?ok');
    }
}