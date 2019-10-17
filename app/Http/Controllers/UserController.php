<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    public function users()
    {
        if (Auth::user()->role_id == 1) {
            $users = DB::table('ab_users')->orderBy('id', 'desc')->get();
            if ($users == !NULL) {
                return view('default.users', ['users' => $users]);
            }else{
                return view('default.users');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function listusers($id)
    {
        if (Auth::user()->role_id == 1) {
            $users = DB::table('ab_users')->orderBy('id', 'desc')->get();
            $user     = DB::table('ab_users')->where('id', $id)->first();
            if ($user == !NULL) {
                if ($id == $user->id) {
                    return view('default.users', ['users' => $users, 'edituser' => $id, 'id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'accounttype' => $user->role_id, 'status' => $user->status, 'created_at' => $user->created_at]);
                } else {
                    return redirect('users');
                }
            }else{
                return redirect('users');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function updateuser(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $currentemail = $request->input('currentemail');
            $id = $request->input('id');
            $name = $request->input('name');
            $email = $request->input('email');
            $new_password = $request->input('new-password');
            $new_password_confirmation = $request->input('new-password_confirmation');
            $accounttype = $request->input('accounttype');
            $status = $request->input('status');

            DB::table('ab_users')->where('id', $id)->where('email', $currentemail)->update(['name' => $name, 'email' => $email, 'role_id' => $accounttype, 'status' => $status]);

            if ($new_password == !NULL && $new_password_confirmation == !NULL) {
                $validatedData = $request->validate([
                    'new-password' => 'required|string|min:8|max:100|confirmed',
                ]);
                $user = DB::table('ab_users')->where('id', $id)->where('email', $currentemail)->first();
                $password = bcrypt($request->get('new-password'));
                DB::table('ab_users')->where('id', $id)->where('email', $email)->update(['password' => $password]);
            }

            return redirect()->back()->with("success","User details changed successfully!");
        }else{
            Auth::logout();
            return redirect('/');
        }
    }

    public function deleteuser($id)
    {
    	if (Auth::user()->role_id == 1) {
            DB::table('ab_users')->where('id', $id)->delete();
            return redirect('users');
    	}else{
    		Auth::logout();
    		return redirect('/');
    	}
    }
}