<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* If you want to disable the register page, delete the double slash "//" at the beginning of the line. And delete line 16 completely. */
// Auth::routes([ 'register' => false ]);
Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('/plans', 'PlanController@index')->name('default.plans');

    Route::get('/plan/{plan}', 'PlanController@show')->name('default.show');

    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');
});

Route::get('payment/{id}', 'PaymentController@show')->name('payment');

Route::post('webhook', 'WebhookController@handleWebhook')->name('webhook');

Route::get('/', function () {
    return view('landing.index');
});

Route::get('/home', 'HomeController@home')->name('home')->middleware('auth');

Route::get('newaccount', 'AccountController@newaccount')->middleware('auth');

Route::get('newproxy', function () {
    return view('default.newproxy');
})->middleware('auth');

Route::get('up', function() {
    Artisan::call('up');
    return redirect('/');
});

Route::post('down', function() {
	$message = $_POST['message'];
    Artisan::call('down --message="'.$message.'"');
    return redirect('/');
});

Route::get('calendar', 'CalendarController@calendar')->middleware('auth');

Route::get('calendar/{date}', 'CalendarController@calendarpost')->middleware('auth');

Route::get('calendar/delete/{username}/{id}', 'CalendarController@calendardelete')->middleware('auth');

Route::get('photodelete/{usename}/{id}', 'UploadController@photodelete')->middleware('auth');

Route::get('photodelhome/{id}', 'UploadController@photodelhome')->middleware('auth');

Route::get('settings', 'SettingController@settings')->middleware('auth');

Route::post('systemsettingsu', 'SettingController@systemsettingsu')->middleware('auth');

Route::post('proxysettingsu', 'SettingController@proxysettingsu')->middleware('auth');

Route::post('followspeedu', 'SettingController@followspeedu')->middleware('auth');

Route::post('unfollowspeedu', 'SettingController@unfollowspeedu')->middleware('auth');

Route::post('likespeedu', 'SettingController@likespeedu')->middleware('auth');

Route::post('commentspeedu', 'SettingController@commentspeedu')->middleware('auth');

Route::post('dmspeedu', 'SettingController@dmspeedu')->middleware('auth');

Route::post('recaptchau', 'SettingController@recaptchau')->middleware('auth');

Route::post('analyticsu', 'SettingController@analyticsu')->middleware('auth');

Route::get('challangem', 'AccountController@challangem')->middleware('auth');

Route::post('challangem', 'AccountController@challangem')->middleware('auth');

Route::get('challange', 'AccountController@challange')->middleware('auth');

Route::post('challange', 'AccountController@challange')->middleware('auth');

Route::get('newchallange', 'AccountController@newchallange')->middleware('auth');

Route::post('newchallange', 'AccountController@newchallange')->middleware('auth');

Route::post('photo-upload', 'UploadController@photoupload')->middleware('auth');

Route::post('home-upload', 'UploadController@homeupload')->middleware('auth');

Route::get('auto-follow', 'FollowController@autofollow')->middleware('auth');

Route::get('auto-follow/{username}', 'FollowController@autofollowdata')->middleware('auth');

Route::get('auto-unfollow', 'UnfollowController@autounfollow')->middleware('auth');

Route::get('auto-unfollow/{username}', 'UnfollowController@autounfollowdata')->middleware('auth');

Route::post('updateunfollow', 'UnfollowController@updateunfollow')->middleware('auth');

Route::get('auto-message', 'MessageController@automessage')->middleware('auth');

Route::get('auto-message/{username}', 'MessageController@automessagedata')->middleware('auth');

Route::post('updatemessage', 'MessageController@updatemessage')->middleware('auth');

Route::get('auto-dmtonew', 'DmtonewController@autodmtonew')->middleware('auth');

Route::get('auto-dmtonew/{username}', 'DmtonewController@autodmtonewdata')->middleware('auth');

Route::post('updatedmtonew', 'DmtonewController@updatedmtonew')->middleware('auth');

Route::get('auto-like', 'LikeController@autolike')->middleware('auth');

Route::get('auto-like/{username}', 'LikeController@autolikedata')->middleware('auth');

Route::post('updatelike', 'LikeController@updatelike')->middleware('auth');

Route::get('auto-comment', 'CommentController@autocomment')->middleware('auth');

Route::get('auto-comment/{username}', 'CommentController@autocommentdata')->middleware('auth');

Route::post('updatecomment', 'CommentController@updatecomment')->middleware('auth');

Route::get('auto-repost', 'RepostController@autorepost')->middleware('auth');

Route::get('auto-repost/{username}', 'RepostController@autorepostdata')->middleware('auth');

Route::post('updaterepost', 'RepostController@updaterepost')->middleware('auth');

Route::get('schedule-posts', 'ScheduleController@scheduleposts')->middleware('auth');

Route::get('schedule-posts/{username}', 'ScheduleController@schedulepostsdata')->middleware('auth');

Route::get('accounts', 'AccountController@accounts')->middleware('auth');

Route::get('profile', 'ProfileController@profile')->middleware('auth');

Route::get('deletetarget/{username}/{where}/{target}', 'AjaxController@deletetarget')->middleware('auth');

Route::post('updatesettings', 'ProfileController@updatesettings')->middleware('auth');

Route::post('privateaccount', 'AccountController@privateaccount')->middleware('auth');

Route::post('addcaption', 'CaptionController@addcaption')->middleware('auth');

Route::get('captions', 'CaptionController@captions')->middleware('auth');

Route::get('captions/{groupname}', 'CaptionController@listcaptions')->middleware('auth');

Route::get('deletecaption/{groupname}/{id}', 'CaptionController@deletecaption')->middleware('auth');

Route::get('deletegroup/{groupname}', 'CaptionController@deletegroup')->middleware('auth');

Route::post('editgroup', 'CaptionController@editgroup')->middleware('auth');

Route::post('addcomment', 'CommentsController@addcomment')->middleware('auth');

Route::get('comments', 'CommentsController@comments')->middleware('auth');

Route::get('comments/{groupname}', 'CommentsController@listcomments')->middleware('auth');

Route::get('deletecomment/{groupname}/{id}', 'CommentsController@deletecomment')->middleware('auth');

Route::get('deletecommentgroup/{groupname}', 'CommentsController@deletecommentgroup')->middleware('auth');

Route::post('editcommentgroup', 'CommentsController@editcommentgroup')->middleware('auth');

Route::post('addblacklist', 'BlacklistController@addblacklist')->middleware('auth');

Route::get('blacklists', 'BlacklistController@blacklists')->middleware('auth');

Route::get('blacklists/{groupname}', 'BlacklistController@listblacklists')->middleware('auth');

Route::get('deleteblacklist/{groupname}/{id}', 'BlacklistController@deleteblacklist')->middleware('auth');

Route::get('deleteblacklistgroup/{groupname}', 'BlacklistController@deleteblacklistgroup')->middleware('auth');

Route::post('editblacklistgroup', 'BlacklistController@editblacklistgroup')->middleware('auth');

Route::get('accounts/{username}', 'AccountController@listaccounts')->middleware('auth');

Route::get('deleteaccount/{username}', 'AccountController@deleteaccount')->middleware('auth');

Route::get('deleteuser/{id}', 'UserController@deleteuser')->middleware('auth');

Route::get('users', 'UserController@users')->middleware('auth');

Route::get('users/{id}', 'UserController@listusers')->middleware('auth');

Route::post('updateuser', 'UserController@updateuser')->middleware('auth');

Route::get('deleteproxy/{id}', 'ProxyController@deleteproxy')->middleware('auth');

Route::get('proxies', 'ProxyController@proxies')->middleware('auth');

Route::get('proxies/{id}', 'ProxyController@listproxies')->middleware('auth');

Route::post('updateproxies', 'ProxyController@updateproxies')->middleware('auth');

Route::post('newproxy', 'ProxyController@newproxy')->middleware('auth');

Route::post('updateproxy', 'ProxyController@updateproxy')->middleware('auth');

Route::get('statistics', 'StatisticController@statistics')->middleware('auth');

Route::get('systemstats', 'StatisticController@systemstats')->middleware('auth');

Route::post('addaccount', 'AccountController@addaccount')->middleware('auth');

Route::post('photopost', 'PostController@photopost')->middleware('auth');

Route::post('albumpost', 'PostController@albumpost')->middleware('auth');

Route::post('storypost', 'PostController@storypost')->middleware('auth');

Route::post('updateschedule', 'ScheduleController@updateschedule')->middleware('auth');

Route::post('updatefollow', 'FollowController@updatefollow')->middleware('auth');

Route::get('cron', 'CronController@cron');

Route::get('check', 'CheckController@check');

Route::post('ajaxRequestU', 'AjaxController@ajaxRequestU');

Route::post('ajaxRequestH', 'AjaxController@ajaxRequestH');

Route::post('/changePassword','PasswordController@changePassword')->name('changePassword');

Route::get('logs','LogController@accounts')->middleware('auth');

Route::get('logs/{username}','LogController@listlogs')->middleware('auth');

Route::get('newlog/{mainuser}/{type}/{username}/{link}','LogController@newlog');

Route::get('newacc/{user_id}/{username}/{password}/{proxy}','AccountController@newacc');