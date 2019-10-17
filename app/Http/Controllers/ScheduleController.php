<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function scheduleposts()
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.schedule-posts', ['accounts' => $accounts]);
        } else {
            return view('default.schedule-posts');
        }
    }

    public function schedulepostsdata($username)
    {
    	$user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $photocheck = DB::select("SELECT * FROM ab_photos WHERE user_id='$user_id'");
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if(!empty($data)){
            $user     = DB::table('ab_schedule_data')->where('user_id', $user_id)->where('account_id', $data->id)->first();
        }else{
            return redirect('schedule-posts');
        }
        $userlock     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $photos = DB::table('ab_photos')->where('user_id', $user_id)->where('username', $username)->orderBy('id', 'desc')->paginate(20);
        $groups   = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'caption')->get();
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.schedule-posts', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'time' => $user->time, 'groups' => $groups, 'captiongroup' => $user->captiongroup, 'deletephoto' => $user->deletephoto, 'random' => $user->random, 'status' => $user->status, 'photos' => $photos, 'photocheck' => $photocheck]);
            } else {
                return redirect('schedule-posts');
            }
        }else{
            return view('default.schedule-posts', ['accounts' => $accounts, 'edituser' => $username, 'username' => $userlock->username, 'time' => "", 'status' => "", 'photos' => $photos, 'photocheck' => $photocheck, 'groups' => $groups, 'captiongroup' => "", 'deletephoto' => "", 'random' => ""]);
        }
    }

    public function updateschedule(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $time = $request->input('time');
        $status = $request->input('status');
        $captiongroup = $request->input('captiongroup');
        $deletephoto = $request->input('deletephoto') ? 1 : 0;
        $random = $request->input('random') ? 1 : 0;
        $query = DB::table('ab_schedule_data')->where('user_id', $user_id)->where('username', $username)->first();
        $data = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($query == NULL) {
            DB::table('ab_schedule_data')->insert(
                    ['user_id' => $user_id, 'account_id' => $data->id, 'username' => $username, 'time' => $time, 'captiongroup' => $captiongroup, 'deletephoto' => $deletephoto, 'random' => $random, 'status' => $status, 'position' => 1, 'timestamp' => time()]
                        );
        }else{
            DB::table('ab_schedule_data')->where('user_id', $user_id)->where('username', $username)->update(['time' => $time, 'captiongroup' => $captiongroup, 'deletephoto' => $deletephoto, 'random' => $random, 'status' => $status]);
        }
        return redirect('schedule-posts/'.$username.'?ok');
    }
}