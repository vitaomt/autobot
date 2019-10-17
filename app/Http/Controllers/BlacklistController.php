<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function blacklists()
    {
        $user_id = Auth::id();
        $groups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'blacklist')->get();

        if ($groups == !NULL) {
            return view('default.blacklists', ['groups' => $groups]);
        } else {
            return view('default.blacklists');
        }
    }
    
    public function listblacklists($groupname)
    {
        $user_id  = Auth::id();
        $groups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'blacklist')->get();
        $lock     = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if (!empty($lock)) {
            $list = DB::table('ab_blacklists')->where('user_id', $user_id)->where('group_id', $lock->id)->get();
        }
        if ($lock == !NULL) {
            if ($groupname == $lock->groupname) {
                return view('default.blacklists', ['list' => $list, 'edituser' => $groupname, 'groupid' => $lock->id, 'groups' => $groups]);
            } else {
                return redirect('blacklists');
            }
        } else {
            return redirect('blacklists');
        }
    }

    public function addblacklist(Request $request)
    {
        $user_id = Auth::id();
        $groupselect = $request->input('groupselect');
        $blacklist = $request->input('blacklist');

        if ($groupselect == "newgroup") {
            $groupname = $request->input('groupname');
            if ($groupname == NULL) {
                return redirect('blacklists?fail');
            }
            $id = DB::table('ab_groups')->insertGetId(['user_id' => $user_id, 'type' => 'blacklist', 'groupname' => $groupname]);
            DB::table('ab_blacklists')->insert(['user_id' => $user_id, 'group_id' => $id, 'blacklist' => $blacklist]);
        }else{
            if ($groupselect == !NULL) {
                $get = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupselect)->first();
                DB::table('ab_blacklists')->insert(['user_id' => $user_id, 'group_id' => $get->id, 'blacklist' => $blacklist]);
            }else{
                return redirect('blacklists?fail');
            }
        }

        return redirect('blacklists?ok');
    }

    public function deleteblacklist($groupname, $id)
    {
        $user_id = Auth::id();
        $group   = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if ($group == !NULL) {
            if ($groupname == $group->groupname) {
                DB::table('ab_blacklists')->where('user_id', $user_id)->where('id', $id)->delete();
                return redirect('blacklists/'.$groupname);
            } else {
                return redirect('blacklists');
            }
        }else{
            return redirect('blacklists');
        }
    }

    public function editblacklistgroup(Request $request)
    {
        $user_id = Auth::id();
        $groupid = $request->input('groupid');
        $groupname = $request->input('groupname');

        DB::table('ab_groups')->where('user_id', $user_id)->where('id', $groupid)->update(['groupname' => $groupname]);
        return redirect('blacklists');
    }

    public function deleteblacklistgroup($groupname)
    {
        $user_id = Auth::id();
        $group   = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if ($group == !NULL) {
            if ($groupname == $group->groupname) {
                DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->delete();
                DB::table('ab_blacklists')->where('user_id', $user_id)->where('group_id', $group->id)->delete();
                return redirect('blacklists');
            } else {
                return redirect('blacklists');
            }
        }else{
            return redirect('blacklists');
        }
    }
}
