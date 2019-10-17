<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function comments()
    {
        $user_id = Auth::id();
        $groups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'comment')->get();

        if ($groups == !NULL) {
            return view('default.comments', ['groups' => $groups]);
        } else {
            return view('default.comments');
        }
    }
    
    public function listcomments($groupname)
    {
        $user_id  = Auth::id();
        $groups = DB::table('ab_groups')->where('user_id', $user_id)->where('type', 'comment')->get();
        $lock     = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if (!empty($lock)) {
            $list = DB::table('ab_comments')->where('user_id', $user_id)->where('group_id', $lock->id)->get();
        }
        if ($lock == !NULL) {
            if ($groupname == $lock->groupname) {
                return view('default.comments', ['list' => $list, 'edituser' => $groupname, 'groupid' => $lock->id, 'groups' => $groups]);
            } else {
                return redirect('comments');
            }
        } else {
            return redirect('comments');
        }
    }

    public function addcomment(Request $request)
    {
        $user_id = Auth::id();
        $groupselect = $request->input('groupselect');
        $comment = $request->input('comment');

        if ($groupselect == "newgroup") {
            $groupname = $request->input('groupname');
            if ($groupname == NULL) {
                return redirect('comments?fail');
            }
            $id = DB::table('ab_groups')->insertGetId(['user_id' => $user_id, 'type' => 'comment', 'groupname' => $groupname]);
            DB::table('ab_comments')->insert(['user_id' => $user_id, 'group_id' => $id, 'comment' => $comment]);
        }else{
            if ($groupselect == !NULL) {
                $get = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupselect)->first();
                DB::table('ab_comments')->insert(['user_id' => $user_id, 'group_id' => $get->id, 'comment' => $comment]);
            }else{
                return redirect('comments?fail');
            }
        }

        return redirect('comments?ok');
    }

    public function deletecomment($groupname, $id)
    {
        $user_id = Auth::id();
        $group   = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if ($group == !NULL) {
            if ($groupname == $group->groupname) {
                DB::table('ab_comments')->where('user_id', $user_id)->where('id', $id)->delete();
                return redirect('comments/'.$groupname);
            } else {
                return redirect('comments');
            }
        }else{
            return redirect('comments');
        }
    }

    public function editcommentgroup(Request $request)
    {
        $user_id = Auth::id();
        $groupid = $request->input('groupid');
        $groupname = $request->input('groupname');

        DB::table('ab_groups')->where('user_id', $user_id)->where('id', $groupid)->update(['groupname' => $groupname]);
        return redirect('comments');
    }

    public function deletecommentgroup($groupname)
    {
        $user_id = Auth::id();
        $group   = DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->first();
        if ($group == !NULL) {
            if ($groupname == $group->groupname) {
                DB::table('ab_groups')->where('user_id', $user_id)->where('groupname', $groupname)->delete();
                DB::table('ab_comments')->where('user_id', $user_id)->where('group_id', $group->id)->delete();
                return redirect('comments');
            } else {
                return redirect('comments');
            }
        }else{
            return redirect('comments');
        }
    }
}
