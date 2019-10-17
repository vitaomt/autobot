<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
	public function proxies()
    {
        if (Auth::user()->role_id == 1) {
            $proxies = DB::table('ab_proxies')->orderBy('id', 'desc')->get();
            if ($proxies == !NULL) {
                return view('default.proxies', ['proxies' => $proxies]);
            }else{
                return view('default.proxies');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function newproxy(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $proxy = $request->input('proxy');
            
            DB::table('ab_proxies')->insert(['proxy' => $proxy]);
            return redirect('proxies');
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function listproxies($id)
    {
        if (Auth::user()->role_id == 1) {
            $proxies = DB::table('ab_proxies')->orderBy('id', 'desc')->get();
            $proxy     = DB::table('ab_proxies')->where('id', $id)->first();
            if ($proxy == !NULL) {
                if ($id == $proxy->id) {
                    return view('default.proxies', ['proxies' => $proxies, 'proxy' => $proxy->proxy, 'editproxy' => $id, 'id' => $proxy->id]);
                } else {
                    return redirect('proxies');
                }
            }else{
                return redirect('proxies');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function updateproxies(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $id = $request->input('id');
            $proxy = $request->input('proxy');

            DB::table('ab_proxies')->where('id', $id)->update(['proxy' => $proxy]);

            return redirect('proxies/'.$id)->with("success","Proxy details changed successfully!");
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function deleteproxy($id)
    {
        if (Auth::user()->role_id == 1) {
            DB::table('ab_proxies')->where('id', $id)->delete();
            return redirect('proxies')->with("success","Proxy deleted successfully.");
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function updateproxy(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $proxy = $request->input('proxy');
        $check = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($check == !NULL) {
            DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->update(['proxy' => $proxy]);
            return redirect('accounts/'.$username.'?proxyok');
        }else{
            return redirect('home');
        }
    }
}