<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function ajaxRequestU(Request $request)
    {
        require 'vendor/filp/autoload.php';
        $user_id    = Auth::id();
        $searchData = $request->input("query");
        $username   = $request->input("usernm");
        $user       = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $pass       = noah($user->password);
        $password   = ulus($pass);

        $ig = new \InstagramAPI\Instagram();
        try {
            $ig->login($username, $password);
            $aa = array(
                $ig->people->search($searchData)
            );
            
            foreach ($aa as $key => $value) {
                $value = json_decode(json_encode($value), true);
                foreach ($value['users'] as $name) { ?>

                <div style="padding: 10px; border-bottom: 1px solid #e2e2e2">
                    <a href="#" class="getUsername">@<?= $name['username'] ?> </a>
                </div>

            <?php }
            }
        }
        catch (\Exception $e) {
            // echo 'Something went wrong, please reload the page.. If problem persist, try again later.';
            $e = str_replace("InstagramAPI\Response\LoginResponse:", "", $e);
            $e = str_replace("Challenge required", "Challenge required, delete account and login to system again", $e);
            echo $e->getMessage() . "\n";
            exit(0);
        }
    }
    
    public function ajaxRequestH(Request $request)
    {
        require 'vendor/filp/autoload.php';
        $user_id    = Auth::id();
        $searchData = $request->input("query");
        $username   = $request->input("usernm");
        $user       = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $pass       = noah($user->password);
        $password   = ulus($pass);
        
        $ig = new \InstagramAPI\Instagram();
        try {
            $ig->login($username, $password);
            $aa = array(
                $ig->hashtag->search($searchData)
            );
            
            foreach ($aa as $key => $value) {
                $value = json_decode(json_encode($value), true);
                foreach ($value['results'] as $name) { ?>

                <div style="padding: 10px; border-bottom: 1px solid #e2e2e2">
                    <a href="#" class="getUsername">#<?= $name['name'] ?> </a>
                </div>
                    
            <?php }
            }
        }
        catch (\Exception $e) {
            // echo 'Something went wrong, please reload the page.. If problem persist, try again later.';
            $e = str_replace("InstagramAPI\Response\LoginResponse:", "", $e);
            $e = str_replace("Challenge required", "Challenge required, delete account and login to system again", $e);
            echo $e->getMessage() . "\n";
            exit(0);
        }
    }

    public function deletetarget($username,$where,$target)
    {
        $user_id = Auth::id();
        if ($where == "follow") {
            $user = DB::table('ab_autofollow_data')->where('user_id', $user_id)->where('username', $username)->first();
            if(!empty($user)){
                $target = str_replace("$", "#", $target);
                $deleted = str_replace($target, "", $user->target);
                DB::table('ab_autofollow_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => trim($deleted)]);
                return back();
            }else{
                return redirect ('home');
            }
            
        }elseif ($where == "like") {
            $user = DB::table('ab_autolike_data')->where('user_id', $user_id)->where('username', $username)->first();
            if(!empty($user)){
                $target = str_replace("$", "#", $target);
                $deleted = str_replace($target, "", $user->target);
                DB::table('ab_autolike_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => trim($deleted)]);
                return back();
            }else{
                return redirect ('home');
            }
        }elseif ($where == "comment") {
            $user = DB::table('ab_autocomment_data')->where('user_id', $user_id)->where('username', $username)->first();
            if(!empty($user)){
                $target = str_replace("$", "#", $target);
                $deleted = str_replace($target, "", $user->target);
                DB::table('ab_autocomment_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => trim($deleted)]);
                return back();
            }else{
                return redirect ('home');
            }
        }elseif ($where == "repost") {
            $user = DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('username', $username)->first();
            if(!empty($user)){
                $target = str_replace("$", "#", $target);
                $deleted = str_replace($target, "", $user->target);
                DB::table('ab_autorepost_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => trim($deleted)]);
                return back();
            }else{
                return redirect ('home');
            }
        }elseif ($where == "message") {
            $user = DB::table('ab_automessage_data')->where('user_id', $user_id)->where('username', $username)->first();
            if(!empty($user)){
                $target = str_replace("$", "#", $target);
                $deleted = str_replace($target, "", $user->target);
                DB::table('ab_automessage_data')->where('user_id', $user_id)->where('username', $username)->update(['target' => trim($deleted)]);
                return back();
            }else{
                return redirect ('home');
            }
        }
        
    }
}