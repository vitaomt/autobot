<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function accounts()
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.log', ['accounts' => $accounts]);
        } else {
            return view('default.log');
        }
    }

    public function listlogs($username)
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $user     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if (!empty($user)) {
            $followlogs = DB::table('ab_logs')->where('username', $username)->where('type', 'autofollow')->orderBy('id', 'desc')->paginate(10);
            $unfollowlogs = DB::table('ab_logs')->where('username', $username)->where('type', 'autounfollow')->orderBy('id', 'desc')->paginate(10);
            $likelogs = DB::table('ab_logs')->where('username', $username)->where('type', 'autolike')->orderBy('id', 'desc')->paginate(10);
            $commentlogs = DB::table('ab_logs')->where('username', $username)->where('type', 'autocomment')->orderBy('id', 'desc')->paginate(10);
            $repostlogs = DB::table('ab_logs')->where('username', $username)->where('type', 'autorepost')->orderBy('id', 'desc')->paginate(10);
            $messagelogs = DB::table('ab_logs')->where('username', $username)->where('type', 'automessage')->orderBy('id', 'desc')->paginate(10);
            $dmtonewlogs = DB::table('ab_logs')->where('username', $username)->where('type', 'autodmtonew')->orderBy('id', 'desc')->paginate(10);
            $schedulelogs = DB::table('ab_logs')->where('username', $username)->where('type', 'schedulepost')->orderBy('id', 'desc')->paginate(10);
            $errorlogs = DB::table('ab_logs')->where('username', $username)->where('type', 'error')->orderBy('id', 'desc')->paginate(10);
        }
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.log', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'followlogs' => $followlogs, 'unfollowlogs' => $unfollowlogs, 'likelogs' => $likelogs, 'commentlogs' => $commentlogs, 'repostlogs' => $repostlogs, 'messagelogs' => $messagelogs, 'dmtonewlogs' => $dmtonewlogs, 'schedulelogs' => $schedulelogs, 'errorlogs' => $errorlogs]);
            } else {
                return redirect('logs');
            }
        }else{
            return redirect('logs');
        }
    }

    public function newlog($mainuser,$type,$username,$link)
    {
        if ($type == "autofollow") {
            $log = array('text' => 'User followed!', 'username' => $username, 'target' => '>', 'ppic' => 'OK');

            DB::table('ab_logs')->insert(['username' => $mainuser, 'type' => 'autofollow', 'log' => json_encode($log)]);

        }elseif ($type == "autounfollow") {
            $log = array('text' => 'User unfollowed!', 'username' => $username, 'target' => '>', 'ppic' => 'OK');

            DB::table('ab_logs')->insert(['username' => $mainuser, 'type' => 'autounfollow', 'log' => json_encode($log)]);

        }elseif ($type == "autolike") {
            $log = array('text' => 'Image liked!', 'link' => $link, 'target' => $username, 'ppic' => 'OK');

            DB::table('ab_logs')->insert(['username' => $mainuser, 'type' => 'autolike', 'log' => json_encode($log)]);

        }elseif ($type == "autocomment") {
            $log = array('text' => 'Comment sent!', 'link' => $link, 'target' => $username, 'ppic' => 'OK');

            DB::table('ab_logs')->insert(['username' => $mainuser, 'type' => 'autocomment', 'log' => json_encode($log)]);

        }
    }
}