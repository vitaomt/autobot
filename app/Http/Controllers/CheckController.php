<?php

namespace Autobot\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Autobot\Http\Controllers\Controller;

class CheckController extends Controller
{
    public function check()
    {
        function clean($str) {
            $str = trim($str);
            $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
            $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
            $str = str_replace($search,$replace,$str);
            $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
            return str_replace("-", " ", $str);
            
        }

    	$accounts = DB::table('ab_accounts')->get();
        foreach ($accounts as $account) {

            $context = stream_context_create(array(
                'http' => array(
                    'header' => 'Connection: close\r\n'
                )
            ));

            $url     = file_get_contents("https://www.instagram.com/".$account->username, false, $context);
            $displaypic = '#<meta property="og:image" content="(.*?)" />#i';
            preg_match_all($displaypic, $url, $doppic);

            $display = '#{"user":{"biography":"(.*?)",.*?,"edge_followed_by":{"count":(.*?)},.*?,"edge_follow":{"count":(.*?)},.*?,"is_private":(.*?),.*?,"edge_owner_to_timeline_media":{"count":(.*?),"page_info":#i';
            preg_match_all($display, $url, $dop);

            $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
            }, $dop[1][0]);

            if ($dop[4][0] == "true") {
                $dop[4][0] = "1";
            }else{
                $dop[4][0] = "0";
            }

            DB::table('ab_accounts')->where('username', $account->username)->update(
                ['profilepic' => $doppic[1][0], 'about' => clean($str), 'private' => $dop[4][0], 'mediacount' => $dop[5][0], 'followercount' => $dop[2][0], 'followingcount' => $dop[3][0]]
            );
        }
    }
}