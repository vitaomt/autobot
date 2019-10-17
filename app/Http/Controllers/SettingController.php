<?php

namespace Autobot\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Autobot\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application setting page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
        if (Auth::user()->role_id == 1) {
            $ssdata = DB::table('ab_settings')->where('name', 'systemsettings')->first();
            $ssdata = json_decode($ssdata->data);
            $psdata = DB::table('ab_settings')->where('name', 'proxysettings')->first();
            $psdata = json_decode($psdata->data);
            $rcdata = DB::table('ab_settings')->where('name', 'recaptcha')->first();
            $rcdata = json_decode($rcdata->data);
            $andata = DB::table('ab_settings')->where('name', 'analytics')->first();
            $andata = json_decode($andata->data);

            $fsdata = DB::table('ab_settings')->where('name', 'followspeeds')->first();
            $fsdata = json_decode($fsdata->data);
            $usdata = DB::table('ab_settings')->where('name', 'unfollowspeeds')->first();
            $usdata = json_decode($usdata->data);
            $lsdata = DB::table('ab_settings')->where('name', 'likespeeds')->first();
            $lsdata = json_decode($lsdata->data);
            $csdata = DB::table('ab_settings')->where('name', 'commentspeeds')->first();
            $csdata = json_decode($csdata->data);
            $dmsdata = DB::table('ab_settings')->where('name', 'dmspeeds')->first();
            $dmsdata = json_decode($dmsdata->data);

            return view('default.settings', ['ssdata' => $ssdata, 'psdata' => $psdata, 'fsdata' => $fsdata, 'usdata' => $usdata, 'lsdata' => $lsdata, 'csdata' => $csdata, 'dmsdata' => $dmsdata, 'rcdata' => $rcdata, 'andata' => $andata]);
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function systemsettingsu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $name = $request->input('name');
            $description = $request->input('description');
            $keywords = $request->input('keywords');

            $ssdata = array('name' => $name, 'description' => $description, 'keywords' => $keywords);
            $check = DB::table('ab_settings')->where('name', 'systemsettings')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'systemsettings')->update(['data' => json_encode($ssdata)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'systemsettings', 'data' => json_encode($ssdata)]);
            }
        }

        return redirect('settings');
    }

    public function proxysettingsu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $sysproxies = $request->input('sysproxies') ? 1 : 0;
            $ownproxy = $request->input('ownproxy') ? 1 : 0;

            $psdata = array('sysproxies' => $sysproxies, 'ownproxy' => $ownproxy);
            $check = DB::table('ab_settings')->where('name', 'proxysettings')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'proxysettings')->update(['data' => json_encode($psdata)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'proxysettings', 'data' => json_encode($psdata)]);
            }
        }

        return redirect('settings');
    }

    public function followspeedu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $fspeedveryslow = $request->input('fspeedveryslow');
            $fspeedslow = $request->input('fspeedslow');
            $fspeedmedium = $request->input('fspeedmedium');
            $fspeedfast = $request->input('fspeedfast');
            $fspeedveryfast = $request->input('fspeedveryfast');

            $data = array('fspeedveryslow' => $fspeedveryslow, 'fspeedslow' => $fspeedslow, 'fspeedmedium' => $fspeedmedium, 'fspeedfast' => $fspeedfast, 'fspeedveryfast' => $fspeedveryfast);
            $check = DB::table('ab_settings')->where('name', 'followspeeds')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'followspeeds')->update(['data' => json_encode($data)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'followspeeds', 'data' => json_encode($data)]);
            }
        }

        return redirect('settings');
    }

    public function unfollowspeedu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $uspeedveryslow = $request->input('uspeedveryslow');
            $uspeedslow = $request->input('uspeedslow');
            $uspeedmedium = $request->input('uspeedmedium');
            $uspeedfast = $request->input('uspeedfast');
            $uspeedveryfast = $request->input('uspeedveryfast');

            $data = array('uspeedveryslow' => $uspeedveryslow, 'uspeedslow' => $uspeedslow, 'uspeedmedium' => $uspeedmedium, 'uspeedfast' => $uspeedfast, 'uspeedveryfast' => $uspeedveryfast);
            $check = DB::table('ab_settings')->where('name', 'unfollowspeeds')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'unfollowspeeds')->update(['data' => json_encode($data)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'unfollowspeeds', 'data' => json_encode($data)]);
            }
        }

        return redirect('settings');
    }

    public function likespeedu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $lspeedveryslow = $request->input('lspeedveryslow');
            $lspeedslow = $request->input('lspeedslow');
            $lspeedmedium = $request->input('lspeedmedium');
            $lspeedfast = $request->input('lspeedfast');
            $lspeedveryfast = $request->input('lspeedveryfast');

            $data = array('lspeedveryslow' => $lspeedveryslow, 'lspeedslow' => $lspeedslow, 'lspeedmedium' => $lspeedmedium, 'lspeedfast' => $lspeedfast, 'lspeedveryfast' => $lspeedveryfast);
            $check = DB::table('ab_settings')->where('name', 'likespeeds')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'likespeeds')->update(['data' => json_encode($data)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'likespeeds', 'data' => json_encode($data)]);
            }
        }

        return redirect('settings');
    }

    public function commentspeedu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $cspeedveryslow = $request->input('cspeedveryslow');
            $cspeedslow = $request->input('cspeedslow');
            $cspeedmedium = $request->input('cspeedmedium');
            $cspeedfast = $request->input('cspeedfast');
            $cspeedveryfast = $request->input('cspeedveryfast');

            $data = array('cspeedveryslow' => $cspeedveryslow, 'cspeedslow' => $cspeedslow, 'cspeedmedium' => $cspeedmedium, 'cspeedfast' => $cspeedfast, 'cspeedveryfast' => $cspeedveryfast);
            $check = DB::table('ab_settings')->where('name', 'commentspeeds')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'commentspeeds')->update(['data' => json_encode($data)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'commentspeeds', 'data' => json_encode($data)]);
            }
        }

        return redirect('settings');
    }

    public function dmspeedu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $dspeedveryslow = $request->input('dspeedveryslow');
            $dspeedslow = $request->input('dspeedslow');
            $dspeedmedium = $request->input('dspeedmedium');
            $dspeedfast = $request->input('dspeedfast');
            $dspeedveryfast = $request->input('dspeedveryfast');

            $data = array('dspeedveryslow' => $dspeedveryslow, 'dspeedslow' => $dspeedslow, 'dspeedmedium' => $dspeedmedium, 'dspeedfast' => $dspeedfast, 'dspeedveryfast' => $dspeedveryfast);
            $check = DB::table('ab_settings')->where('name', 'dmspeeds')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'dmspeeds')->update(['data' => json_encode($data)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'dmspeeds', 'data' => json_encode($data)]);
            }
        }

        return redirect('settings');
    }

    public function recaptchau(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $sitekey = $request->input('sitekey');
            $secret = $request->input('secret');

            $rcdata = array('sitekey' => $sitekey, 'secret' => $secret);
            $check = DB::table('ab_settings')->where('name', 'recaptcha')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'recaptcha')->update(['data' => json_encode($rcdata)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'recaptcha', 'data' => json_encode($rcdata)]);
            }
        }

        return redirect('settings');
    }

    public function analyticsu(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $analyticsid = $request->input('analyticsid');

            $andata = array('analyticsid' => $analyticsid);
            $check = DB::table('ab_settings')->where('name', 'analytics')->first();

            if ($check == !NULL) {
                DB::table('ab_settings')->where('name', 'analytics')->update(['data' => json_encode($andata)]);
            }else{
                DB::table('ab_settings')->insert(['name' => 'analytics', 'data' => json_encode($andata)]);
            }
        }

        return redirect('settings');
    }
}
