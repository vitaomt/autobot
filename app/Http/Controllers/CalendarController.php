<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function calendar()
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $posts = DB::table('ab_scheduledposts')->where('user_id', $user_id)->get();

        if (isset($_GET['date'])) {
            if ($_GET['date'] == "January") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 32, 'month' => '01', 'pre' => 'December', 'next' => 'February', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'January']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "February") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 29, 'month' => '02', 'pre' => 'January', 'next' => 'March', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'February']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "March") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 32, 'month' => '03', 'pre' => 'February', 'next' => 'April', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'March']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "April") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 31, 'month' => '04', 'pre' => 'March', 'next' => 'May', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'April']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "May") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 31, 'month' => '05', 'pre' => 'April', 'next' => 'June', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'May']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "June") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 31, 'month' => '06', 'pre' => 'May', 'next' => 'July', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'June']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "July") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 32, 'month' => '07', 'pre' => 'June', 'next' => 'August', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'July']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "August") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 32, 'month' => '08', 'pre' => 'July', 'next' => 'September', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'August']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "September") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 31, 'month' => '09', 'pre' => 'August', 'next' => 'October', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'September']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "October") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 32, 'month' => '10', 'pre' => 'September', 'next' => 'November', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'October']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "November") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 31, 'month' => '11', 'pre' => 'October', 'next' => 'December', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'November']);
                } else {
                    return view('default.calendar');
                }
            }elseif ($_GET['date'] == "December") {
                if ($accounts == !NULL) {
                    return view('default.calendar', ['accounts' => $accounts, 'day' => 32, 'month' => '12', 'pre' => 'November', 'next' => 'January', 'posts' => $posts, 'date_y' => date("Y"), 'date_f' => 'December']);
                } else {
                    return view('default.calendar');
                }
            }else{
                return redirect('calendar?date='.date("F"));
            }
        }else{
            return redirect('calendar?date='.date("F"));
        }
    }

    public function calendarpost($date)
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $posts = DB::table('ab_scheduledposts')->where('user_id', $user_id)->get();
        if ($accounts == !NULL) {
            return view('default.calendarpost', ['posts' => $posts, 'date' => $date]);
        } else {
            return view('default.calendarpost');
        }
    }

    public function calendardelete($username, $id)
    {
        $user_id = Auth::id();
        $user     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($user == !NULL) {
            if ($username == $user->username) {
                $data = DB::table('ab_scheduledposts')->where('id', $id)->where('username', $user->username)->first();
                $explode = explode(" ", $data->date);

                DB::table('ab_scheduledposts')->where('id', $id)->where('username', $user->username)->delete();

                return redirect('calendar/'.$explode[0]);
            } else {
                return redirect('calendar');
            }
        }else{
            return redirect('calendar');
        }
    }
}