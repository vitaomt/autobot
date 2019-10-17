<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function homeupload(Request $request)
    {
        $user_id = Auth::id();
        $count = count($_FILES['photo']['tmp_name']);
        for ($i=0; $i < $count; $i++) {
            if(!empty($_FILES['photo']['name'][$i])){ 
        $photo = $_FILES['photo']['tmp_name'][$i];
        $size = $_FILES['photo']['size'][$i];
        $rand = rand(1, 1000000);
        Storage::putFileAs('photos/home/'.$user_id, new File($photo), $rand.'.jpg');
        DB::table('ab_photos')->insert(['user_id' => $user_id, 'photo' => $rand.'.jpg', 'size' => $size]);
            }
        }
        return redirect('home');
    }

    public function photoupload(Request $request)
    {
        $user_id = Auth::id();
        $username = $request->input('username');
        $account = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $username)->first();
        $count = count($_FILES['photo']['tmp_name']);
        for ($i=0; $i < $count; $i++) {
            if(!empty($_FILES['photo']['name'][$i])){ 
        $photo = $_FILES['photo']['tmp_name'][$i];
        $size = $_FILES['photo']['size'][$i];
        $rand = rand(1, 1000000);
        Storage::putFileAs('photos/'.$user_id, new File($photo), $rand.'.jpg');
        DB::table('ab_photos')->insert(['user_id' => $user_id, 'account_id' => $account->id, 'username' => $username, 'photo' => $rand.'.jpg', 'size' => $size]);
            }
        }
        return redirect('schedule-posts/'.$username);
    }

    public function photodelete($username, $id)
    {
        $user_id = Auth::id();
        $photo   = DB::table('ab_photos')->where('user_id', $user_id)->where('id', $id)->first();
        if ($photo == !NULL) {
            if ($id == $photo->id) {
                DB::table('ab_photos')->where('user_id', $user_id)->where('id', $id)->delete();
                return redirect('schedule-posts/'.$username);
            } else {
                return redirect('schedule-posts');
            }
        }else{
            return redirect('schedule-posts');
        }
    }

    public function photodelhome($id)
    {
        $user_id = Auth::id();
        $photo   = DB::table('ab_photos')->where('user_id', $user_id)->where('id', $id)->first();
        if ($photo == !NULL) {
            if ($id == $photo->id) {
                DB::table('ab_photos')->where('user_id', $user_id)->where('id', $id)->delete();
                return redirect('home');
            } else {
                return redirect('home');
            }
        }else{
            return redirect('home');
        }
    }
}