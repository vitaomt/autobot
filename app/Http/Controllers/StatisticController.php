<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Autobot\User;
use Autobot\Charts\UserChart;

class StatisticController extends Controller
{
    public function statistics()
    {
        $user_id = Auth::id();
        $check = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($check == !NULL) {
            foreach ($check as $key) {
                $today_logs = DB::table('ab_logs')->where('username', $key->username)->whereDate('date', today())->count();
            
                for ($i=1; $i < 30; $i++) { 
                    ${'logsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->whereDate('date', today()->subDays($i))->count();
                }
            }

            $chart2 = new UserChart;
            $chart2->labels(['29 days ago', '28 days ago', '27 days ago', '26 days ago', '25 days ago', '24 days ago', '23 days ago', '22 days ago', '21 days ago', '20 days ago', '19 days ago', '18 days ago', '17 days ago', '16 days ago', '15 days ago', '14 days ago', '13 days ago', '12 days ago', '11 days ago', '10 days ago', '9 days ago', '8 days ago', '7 days ago', '6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);
            $chart2->dataset('Monthly Action Logs', 'line', [$logsof29, $logsof28, $logsof27, $logsof26, $logsof25, $logsof24, $logsof23, $logsof22, $logsof21, $logsof20, $logsof19, $logsof18, $logsof17, $logsof16, $logsof15, $logsof14, $logsof13, $logsof12, $logsof11, $logsof10, $logsof9, $logsof8, $logsof7, $logsof6, $logsof5, $logsof4, $logsof3, $logsof2, $logsof1, $today_logs])->options(['backgroundColor' => '#667eea75']);

            foreach ($check as $key) {
                $ftoday_actions = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autofollow')->whereDate('date', today())->count();
                $utoday_actions = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autounfollow')->whereDate('date', today())->count();
                $ltoday_actions = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autolike')->whereDate('date', today())->count();
                $ctoday_actions = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autocomment')->whereDate('date', today())->count();
                $rtoday_actions = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autorepost')->whereDate('date', today())->count();
                $dtoday_actions = DB::table('ab_logs')->where('username', $key->username)->where('type', 'automessage')->where('type', 'autodmtonew')->whereDate('date', today())->count();

                for ($i=1; $i < 7; $i++) { 
                    ${'factionsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autofollow')->whereDate('date', today()->subDays($i))->count();
                }
                for ($i=1; $i < 7; $i++) { 
                    ${'uactionsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autounfollow')->whereDate('date', today()->subDays($i))->count();
                }
                for ($i=1; $i < 7; $i++) { 
                    ${'lactionsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autolike')->whereDate('date', today()->subDays($i))->count();
                }
                for ($i=1; $i < 7; $i++) { 
                    ${'cactionsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autocomment')->whereDate('date', today()->subDays($i))->count();
                }
                for ($i=1; $i < 7; $i++) { 
                    ${'ractionsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->where('type', 'autorepost')->whereDate('date', today()->subDays($i))->count();
                }
                for ($i=1; $i < 7; $i++) { 
                    ${'dactionsof'.$i} = DB::table('ab_logs')->where('username', $key->username)->where('type', 'automessage')->where('type', 'autodmtonew')->whereDate('date', today()->subDays($i))->count();
                }
            }

            $chart3 = new UserChart;
            $chart3->labels(['6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);
            $chart3->dataset('Follow Logs', 'bar', [$factionsof6, $factionsof5, $factionsof4, $factionsof3, $factionsof2, $factionsof1, $ftoday_actions])->options(['backgroundColor' => '#ff8ca452', 'borderColor' => '#ff8ca4']);
            $chart3->dataset('Unfollow Logs', 'line', [$uactionsof6, $uactionsof5, $uactionsof4, $uactionsof3, $uactionsof2, $uactionsof1, $utoday_actions])->options(['backgroundColor' => '#f8b16b52', 'borderColor' => '#f8b16b']);
            $chart3->dataset('Like Logs', 'line', [$lactionsof6, $lactionsof5, $lactionsof4, $lactionsof3, $lactionsof2, $lactionsof1, $ltoday_actions])->options(['backgroundColor' => '#7ad1d152', 'borderColor' => '#7ad1d1']);
            $chart3->dataset('Comment Logs', 'line', [$cactionsof6, $cactionsof5, $cactionsof4, $cactionsof3, $cactionsof2, $cactionsof1, $ctoday_actions])->options(['backgroundColor' => '#6bbaf052', 'borderColor' => '#6bbaf0']);
            $chart3->dataset('Repost Logs', 'line', [$ractionsof6, $ractionsof5, $ractionsof4, $ractionsof3, $ractionsof2, $ractionsof1, $rtoday_actions])->options(['backgroundColor' => '#ffda8252', 'borderColor' => '#ffda82']);
            $chart3->dataset('DM Logs', 'line', [$dactionsof6, $dactionsof5, $dactionsof4, $dactionsof3, $dactionsof2, $dactionsof1, $dtoday_actions])->options(['backgroundColor' => '#b48eff52', 'borderColor' => '#b48eff']);

            $useraccounts = DB::table('ab_accounts')->where('user_id', $user_id)->count();
            $useraction = DB::table('ab_logs')->get();
            $useractions = 0;
            foreach ($useraction as $key) {
                if (DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $key->username)->exists()) {
                    $useractions++;
                }
            }
            $userphotos = DB::table('ab_photos')->where('user_id', $user_id)->count();

            return view('default.statistics', ['chart2' => $chart2, 'chart3' => $chart3, 'useraccounts' => $useraccounts, 'useractions' => $useractions, 'userphotos' => $userphotos, 'check' => $check]);
        }else{
            return view('default.statistics', ['chart2' => "", 'chart3' => "", 'useraccounts' => "", 'useractions' => "", 'userphotos' => ""]);
        }
    }

    public function systemstats()
    {
        $today_users = User::whereDate('created_at', today())->count();

        for ($i=1; $i < 30; $i++) { 
            ${'usersof'.$i} = User::whereDate('created_at', today()->subDays($i))->count();
        }

        $chart = new UserChart;
        $chart->labels(['29 days ago', '28 days ago', '27 days ago', '26 days ago', '25 days ago', '24 days ago', '23 days ago', '22 days ago', '21 days ago', '20 days ago', '19 days ago', '18 days ago', '17 days ago', '16 days ago', '15 days ago', '14 days ago', '13 days ago', '12 days ago', '11 days ago', '10 days ago', '9 days ago', '8 days ago', '7 days ago', '6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);
        $chart->dataset('Monthly Registered Users', 'bar', [$usersof29, $usersof28, $usersof27, $usersof26, $usersof25, $usersof24, $usersof23, $usersof22, $usersof21, $usersof20, $usersof19, $usersof18, $usersof17, $usersof16, $usersof15, $usersof14, $usersof13, $usersof12, $usersof11, $usersof10, $usersof9, $usersof8, $usersof7, $usersof6, $usersof5, $usersof4, $usersof3, $usersof2, $usersof1, $today_users])->options(['backgroundColor' => '#764ba261']);

        $today_logs = DB::table('ab_logs')->whereDate('date', today())->count();

        for ($i=1; $i < 30; $i++) { 
            ${'logsof'.$i} = DB::table('ab_logs')->whereDate('date', today()->subDays($i))->count();
        }

        $chart2 = new UserChart;
        $chart2->labels(['29 days ago', '28 days ago', '27 days ago', '26 days ago', '25 days ago', '24 days ago', '23 days ago', '22 days ago', '21 days ago', '20 days ago', '19 days ago', '18 days ago', '17 days ago', '16 days ago', '15 days ago', '14 days ago', '13 days ago', '12 days ago', '11 days ago', '10 days ago', '9 days ago', '8 days ago', '7 days ago', '6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);
        $chart2->dataset('Monthly Action Logs', 'line', [$logsof29, $logsof28, $logsof27, $logsof26, $logsof25, $logsof24, $logsof23, $logsof22, $logsof21, $logsof20, $logsof19, $logsof18, $logsof17, $logsof16, $logsof15, $logsof14, $logsof13, $logsof12, $logsof11, $logsof10, $logsof9, $logsof8, $logsof7, $logsof6, $logsof5, $logsof4, $logsof3, $logsof2, $logsof1, $today_logs])->options(['backgroundColor' => '#667eea75']);

        $ftoday_actions = DB::table('ab_logs')->where('type', 'autofollow')->whereDate('date', today())->count();
        $utoday_actions = DB::table('ab_logs')->where('type', 'autounfollow')->whereDate('date', today())->count();
        $ltoday_actions = DB::table('ab_logs')->where('type', 'autolike')->whereDate('date', today())->count();
        $ctoday_actions = DB::table('ab_logs')->where('type', 'autocomment')->whereDate('date', today())->count();
        $rtoday_actions = DB::table('ab_logs')->where('type', 'autorepost')->whereDate('date', today())->count();
        $dtoday_actions = DB::table('ab_logs')->where('type', 'automessage')->where('type', 'autodmtonew')->whereDate('date', today())->count();

        for ($i=1; $i < 7; $i++) { 
            ${'factionsof'.$i} = DB::table('ab_logs')->where('type', 'autofollow')->whereDate('date', today()->subDays($i))->count();
        }
        for ($i=1; $i < 7; $i++) { 
            ${'uactionsof'.$i} = DB::table('ab_logs')->where('type', 'autounfollow')->whereDate('date', today()->subDays($i))->count();
        }
        for ($i=1; $i < 7; $i++) { 
            ${'lactionsof'.$i} = DB::table('ab_logs')->where('type', 'autolike')->whereDate('date', today()->subDays($i))->count();
        }
        for ($i=1; $i < 7; $i++) { 
            ${'cactionsof'.$i} = DB::table('ab_logs')->where('type', 'autocomment')->whereDate('date', today()->subDays($i))->count();
        }
        for ($i=1; $i < 7; $i++) { 
            ${'ractionsof'.$i} = DB::table('ab_logs')->where('type', 'autorepost')->whereDate('date', today()->subDays($i))->count();
        }
        for ($i=1; $i < 7; $i++) { 
            ${'dactionsof'.$i} = DB::table('ab_logs')->where('type', 'automessage')->where('type', 'autodmtonew')->whereDate('date', today()->subDays($i))->count();
        }

        $chart3 = new UserChart;
        $chart3->labels(['6 days ago', '5 days ago', '4 days ago', '3 days ago', '2 days ago', 'Yesterday', 'Today']);
        $chart3->dataset('Follow Logs', 'bar', [$factionsof6, $factionsof5, $factionsof4, $factionsof3, $factionsof2, $factionsof1, $ftoday_actions])->options(['backgroundColor' => '#ff8ca452', 'borderColor' => '#ff8ca4']);
        $chart3->dataset('Unfollow Logs', 'line', [$uactionsof6, $uactionsof5, $uactionsof4, $uactionsof3, $uactionsof2, $uactionsof1, $utoday_actions])->options(['backgroundColor' => '#f8b16b52', 'borderColor' => '#f8b16b']);
        $chart3->dataset('Like Logs', 'line', [$lactionsof6, $lactionsof5, $lactionsof4, $lactionsof3, $lactionsof2, $lactionsof1, $ltoday_actions])->options(['backgroundColor' => '#7ad1d152', 'borderColor' => '#7ad1d1']);
        $chart3->dataset('Comment Logs', 'line', [$cactionsof6, $cactionsof5, $cactionsof4, $cactionsof3, $cactionsof2, $cactionsof1, $ctoday_actions])->options(['backgroundColor' => '#6bbaf052', 'borderColor' => '#6bbaf0']);
        $chart3->dataset('Repost Logs', 'line', [$ractionsof6, $ractionsof5, $ractionsof4, $ractionsof3, $ractionsof2, $ractionsof1, $rtoday_actions])->options(['backgroundColor' => '#ffda8252', 'borderColor' => '#ffda82']);
        $chart3->dataset('DM Logs', 'line', [$dactionsof6, $dactionsof5, $dactionsof4, $dactionsof3, $dactionsof2, $dactionsof1, $dtoday_actions])->options(['backgroundColor' => '#b48eff52', 'borderColor' => '#b48eff']);

        $users = DB::table('ab_users')->count();
        $accounts = DB::table('ab_accounts')->count();
        $actions = DB::table('ab_logs')->count();
        $photos = DB::table('ab_photos')->count();

        return view('default.systemstats', ['chart' => $chart, 'chart2' => $chart2, 'chart3' => $chart3, 'users' => $users, 'accounts' => $accounts, 'actions' => $actions, 'photos' => $photos]);
    }
}