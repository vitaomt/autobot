<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
	public function photopost(Request $request)
	{
		set_time_limit(0);
        date_default_timezone_set('UTC');
        ini_set('max_execution_time', '0');
        require 'vendor/filp/autoload.php';
        $ig      = new \InstagramAPI\Instagram();
		$user_id = Auth::id();
		$accountselect = $request->input('accountselect');
		$imageurl = $request->input('imageurl');
		$captions = $request->input('caption');
		$location = $request->input('location');
		$postnow = $request->input('postnow') ? 1 : 0;
		$date = $request->input('date');
		$deletephoto = $request->input('deletephoto') ? 1 : 0;

		if ($postnow == 1) {
			
			try {
	            $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

	            if (!empty($proxies)) {
	                $ig->setProxy($proxies->proxy);
	            }

	            $account  = DB::table('ab_accounts')->where('username', $accountselect)->first();
	            $pass     = noah($account->password);
	            $password = ulus($pass);

	            $ig->login($accountselect, $password);
	        }
	        catch (\Exception $e) {
	            // DB::table('ab_logs')->insert(['user_id' => $user_id, 'account_id' => $data->account_id, 'username' => $data->username, 'type' => 'login', 'log' => $e->getMessage()]);
	            if ($e->getMessage() == "Trying to get property 'password' of non-object") {
	            	$error = "Please select an account.";
	            	return redirect('home?error='.$error);
	            }else{
	            	return redirect('home?error='.$e->getMessage());
	            }
	            exit(0);
	        }

	        try {
	        	$rankToken = \InstagramAPI\Signatures::generateUUID();

		        $explode = explode("/", $imageurl);
				$count = count($explode);
				$explode = $explode[$count-1];
				$imageurl = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		        if ($captions != NULL) {
		            $caption = $captions;
		        }else{
		            $caption = "";
		        }

		        if ($location != NULL) {
			        $location = $ig->location->findPlaces($location, [], $rankToken);
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
	            if ($deletephoto == 1) {
	                unlink($imageurl);
	                DB::table('ab_photos')->where('user_id', $user_id)->where('photo', $explode)->delete();
	            }

	            return redirect('home?ok=Photo shared succesfully!');
	        }
	        catch (\Exception $e) {
	            // DB::table('ab_logs')->insert(['user_id' => $user_id, 'account_id' => $data->account_id, 'username' => $data->username, 'type' => 'login', 'log' => $e->getMessage()]);
	            if (strpos($e->getMessage(), 'storage/app/photos/home/') !== false) {
	            	$error = "Please select a media from left side list.";
	            	return redirect('home?error='.$error);
	            }else{
	            	return redirect('home?error='.$e->getMessage());
	            }
	            exit(0);
	        }
		}else{
			$account = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $accountselect)->first();
			DB::table('ab_scheduledposts')->insert(['user_id' => $user_id, 'account_id' => $account->id, 'username' => $account->username, 'type' => "single", 'imageurl' => $imageurl, 'caption' => $captions, 'location' => $location, 'date' => $date, 'deletephoto' => $deletephoto]);
			return redirect('home?ok=Photo saved for schedule!');
		}
	}

	public function albumpost(Request $request)
	{
		set_time_limit(0);
        date_default_timezone_set('UTC');
        ini_set('max_execution_time', '0');
        require 'vendor/filp/autoload.php';
        $ig      = new \InstagramAPI\Instagram();
		$user_id = Auth::id();
		$accountselect = $request->input('accountselect');
		$imageurl = $request->input('album');
		$captions = $request->input('caption');
		$location = $request->input('location');
		$postnow = $request->input('postnow') ? 1 : 0;
		$date = $request->input('date');
		$deletephoto = $request->input('deletephoto') ? 1 : 0;

		if ($postnow == 1) {
			
			try {
	            $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

	            if (!empty($proxies)) {
	                $ig->setProxy($proxies->proxy);
	            }

	            $account  = DB::table('ab_accounts')->where('username', $accountselect)->first();
	            $pass     = noah($account->password);
	            $password = ulus($pass);

	            $ig->login($accountselect, $password);
	        }
	        catch (\Exception $e) {
	            // DB::table('ab_logs')->insert(['user_id' => $user_id, 'account_id' => $data->account_id, 'username' => $data->username, 'type' => 'login', 'log' => $e->getMessage()]);
	            if ($e->getMessage() == "Trying to get property 'password' of non-object") {
	            	$error = "Please select an account.";
	            	return redirect('home?error='.$error);
	            }else{
	            	return redirect('home?error='.$e->getMessage());
	            }
	            exit(0);
	        }

	        try {
	        	if ($captions != NULL) {
		            $caption = $captions;
		        }else{
		            $caption = "";
		        }

		        if (!empty($imageurl[0])) {
			        $explode = explode("/", $imageurl[0]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path0 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media0 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path0,
					    ]
					];

					$result = array_merge($media0);
				}

				if (!empty($imageurl[1])) {
			        $explode = explode("/", $imageurl[1]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path1 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media1 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path1,
					    ]
					];

					$result = array_merge($media0, $media1);
				}

				if (!empty($imageurl[2])) {
			        $explode = explode("/", $imageurl[2]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path2 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media2 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path2,
					    ]
					];

					$result = array_merge($media0, $media1, $media2);
				}

				if (!empty($imageurl[3])) {
			        $explode = explode("/", $imageurl[3]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path3 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media3 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path3,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3);
				}

				if (!empty($imageurl[4])) {
			        $explode = explode("/", $imageurl[4]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path4 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media4 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path4,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3, $media4);
				}

				if (!empty($imageurl[5])) {
			        $explode = explode("/", $imageurl[5]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path5 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media5 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path5,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3, $media4, $media5);
				}

				if (!empty($imageurl[6])) {
			        $explode = explode("/", $imageurl[6]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path6 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media6 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path6,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3, $media4, $media5, $media6);
				}

				if (!empty($imageurl[7])) {
			        $explode = explode("/", $imageurl[7]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path7 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media7 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path7,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3, $media4, $media5, $media6, $media7);
				}

				if (!empty($imageurl[8])) {
			        $explode = explode("/", $imageurl[8]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path8 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media8 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path8,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3, $media4, $media5, $media6, $media7, $media8);
				}

				if (!empty($imageurl[9])) {
			        $explode = explode("/", $imageurl[9]);
					$count = count($explode);
					$explode = $explode[$count-1];
					$path9 = 'storage/app/photos/home/' . $user_id . '/' . $explode;

		            $media9 = [
					    [
					        'type'     => 'photo',
					        'file'     => $path9,
					    ]
					];

					$result = array_merge($media0, $media1, $media2, $media3, $media4, $media5, $media6, $media7, $media8, $media9);
				}

				$mediaOptions = [
				    'targetFeed' => \InstagramAPI\Constants::FEED_TIMELINE_ALBUM
				];
				foreach ($result as &$item) {
				    $validMedia = null;
				    switch ($item['type']) {
				        case 'photo':
				            $validMedia = new \InstagramAPI\Media\Photo\InstagramPhoto($item['file'], $mediaOptions);
				            break;
				        case 'video':
				            $validMedia = new \InstagramAPI\Media\Video\InstagramVideo($item['file'], $mediaOptions);
				            break;
				        default:
				    }
				    if ($validMedia === null) {
				        continue;
				    }

			        $item['file'] = $validMedia->getFile();
			        $item['__media'] = $validMedia;
				    if (!isset($mediaOptions['forceAspectRatio'])) {
				        $mediaDetails = $validMedia instanceof \InstagramAPI\Media\Photo\InstagramPhoto
				            ? new \InstagramAPI\Media\Photo\PhotoDetails($item['file'])
				            : new \InstagramAPI\Media\Video\VideoDetails($item['file']);
				        $mediaOptions['forceAspectRatio'] = $mediaDetails->getAspectRatio();
				    }
				}

				$ig->timeline->uploadAlbum($result, ['caption' => $caption]);

	            // if ($deletephoto == 1) {
	            //     unlink($imageurl);
	            //     DB::table('ab_photos')->where('user_id', $user_id)->where('photo', $explode)->delete();
	            // }

	            return redirect('home?ok=Photo shared succesfully!');
	        }
	        catch (\Exception $e) {
	            // DB::table('ab_logs')->insert(['user_id' => $user_id, 'account_id' => $data->account_id, 'username' => $data->username, 'type' => 'login', 'log' => $e->getMessage()]);
	            if (strpos($e->getMessage(), 'storage/app/photos/home/') !== false) {
	            	$error = "Please select a media from left side list.";
	            	return redirect('home?error='.$error);
	            }else{
	            	return redirect('home?error='.$e->getMessage());
	            }
	            exit(0);
	        }
		}else{
			$imageurl = json_encode($imageurl);
			$account = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $accountselect)->first();
			DB::table('ab_scheduledposts')->insert(['user_id' => $user_id, 'account_id' => $account->id, 'username' => $account->username, 'type' => "album", 'imageurl' => $imageurl, 'caption' => $captions, 'location' => $location, 'date' => $date, 'deletephoto' => $deletephoto]);
			return redirect('home?ok=Photo saved for schedule!');
		}
	}

	public function storypost(Request $request)
	{
		set_time_limit(0);
        date_default_timezone_set('UTC');
        ini_set('max_execution_time', '0');
        require 'vendor/filp/autoload.php';
        $ig      = new \InstagramAPI\Instagram();
		$user_id = Auth::id();
		$accountselect = $request->input('accountselect');
		$imageurl = $request->input('imageurl');
		$postnow = $request->input('postnow') ? 1 : 0;
		$date = $request->input('date');
		$deletephoto = $request->input('deletephoto') ? 1 : 0;

		if ($postnow == 1) {
			
			try {
	            $proxies = DB::table('ab_proxies')->inRandomOrder()->first();

	            if (!empty($proxies)) {
	                $ig->setProxy($proxies->proxy);
	            }

	            $account  = DB::table('ab_accounts')->where('username', $accountselect)->first();
	            $pass     = noah($account->password);
	            $password = ulus($pass);

	            $ig->login($accountselect, $password);
	        }
	        catch (\Exception $e) {
	            // DB::table('ab_logs')->insert(['user_id' => $user_id, 'account_id' => $data->account_id, 'username' => $data->username, 'type' => 'login', 'log' => $e->getMessage()]);
	            if ($e->getMessage() == "Trying to get property 'password' of non-object") {
	            	$error = "Please select an account.";
	            	return redirect('home?error='.$error);
	            }else{
	            	return redirect('home?error='.$e->getMessage());
	            }
	            exit(0);
	        }

	        try {
	        	$rankToken = \InstagramAPI\Signatures::generateUUID();

		        $explode = explode("/", $imageurl);
				$count = count($explode);
				$explode = $explode[$count-1];
				$imageurl = 'storage/app/photos/home/' . $user_id . '/' . $explode;

	            $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($imageurl, ['targetFeed' => \InstagramAPI\Constants::FEED_STORY]);
    			$ig->story->uploadPhoto($photo->getFile());

	            if ($deletephoto == 1) {
	                unlink($imageurl);
	                DB::table('ab_photos')->where('user_id', $user_id)->where('photo', $explode)->delete();
	            }

	            return redirect('home?ok=Photo shared succesfully!');
	        }
	        catch (\Exception $e) {
	            // DB::table('ab_logs')->insert(['user_id' => $user_id, 'account_id' => $data->account_id, 'username' => $data->username, 'type' => 'login', 'log' => $e->getMessage()]);
	            if (strpos($e->getMessage(), 'storage/app/photos/home/') !== false) {
	            	$error = "Please select a media from left side list.";
	            	return redirect('home?error='.$error);
	            }else{
	            	return redirect('home?error='.$e->getMessage());
	            }
	            exit(0);
	        }
		}else{
			$account = DB::table('ab_accounts')->where('user_id', $user_id)->where('username', $accountselect)->first();
			DB::table('ab_scheduledposts')->insert(['user_id' => $user_id, 'account_id' => $account->id, 'username' => $account->username, 'type' => "story", 'imageurl' => $imageurl, 'caption' => $captions, 'location' => $location, 'date' => $date, 'deletephoto' => $deletephoto]);
			return redirect('home?ok=Photo saved for schedule!');
		}
	}
}