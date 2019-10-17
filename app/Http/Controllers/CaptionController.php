<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CaptionController extends Controller
{
    public function captions()
    {
        $user_id = Auth::id();
        $groups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'caption')->get();

        if ($groups == !NULL) {
            return view('default.captions', ['groups' => $groups]);
        } else {
            return view('default.captions');
        }
    }
    
    public function listcaptions($groupname)
    {
        $user_id  = Auth::id();
        $groups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'caption')->get();
        $lock     = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if (!empty($lock)) {
            $list = DB::table('ab_captions')->where('user_id', $user_id)->where('group_id', $lock->id)->get();
        }
        if ($lock == !NULL) {
            if ($groupname == $lock->groupname) {
                return view('default.captions', ['list' => $list, 'edituser' => $groupname, 'groupid' => $lock->id, 'groups' => $groups]);
            } else {
                return redirect('captions');
            }
        } else {
            return redirect('captions');
        }
    }

    public function addcaption(Request $request)
    {
        $user_id = Auth::id();
        $groupselect = $request->input('groupselect');
        $caption = $request->input('caption');

        if ($groupselect == "newgroup") {
            $groupname = $request->input('groupname');
            if ($groupname == NULL) {
                return redirect('captions?fail');
            }
            $id = DB::table('ab_groups')->insertGetId(['user_id' => $user_id, 'type' => 'caption', 'groupname' => $groupname]);
            DB::table('ab_captions')->insert(['user_id' => $user_id, 'group_id' => $id, 'caption' => $caption]);
        }else{
            if ($groupselect == !NULL) {
                $get = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupselect)->first();
                DB::table('ab_captions')->insert(['user_id' => $user_id, 'group_id' => $get->id, 'caption' => $caption]);
            }else{
                return redirect('captions?fail');
            }
        }

        return redirect('captions?ok');
    }

    public function deletecaption($groupname, $id)
    {
        $user_id = Auth::id();
        $group   = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if ($group == !NULL) {
            if ($groupname == $group->groupname) {
                DB::table('ab_captions')->where('user_id', $user_id)->where('id', $id)->delete();
                return redirect('captions/'.$groupname);
            } else {
                return redirect('captions');
            }
        }else{
            return redirect('captions');
        }
    }

    public function editgroup(Request $request)
    {
        $user_id = Auth::id();
        $groupid = $request->input('groupid');
        $groupname = $request->input('groupname');

        DB::table('ab_groups')->where('user_id', $user_id)->where('id', $groupid)->update(['groupname' => $groupname]);
        return redirect('captions');
    }

    public function deletegroup($groupname)
    {
        $user_id = Auth::id();
        $group   = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if ($group == !NULL) {
            if ($groupname == $group->groupname) {
                DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->delete();
                DB::table('ab_captions')->where('user_id', $user_id)->where('group_id', $group->id)->delete();
                return redirect('captions');
            } else {
                return redirect('captions');
            }
        }else{
            return redirect('captions');
        }
    }
}
