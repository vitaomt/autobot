<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ config('app.title') }}</title>
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="keywords" content="{{ config('app.keywords') }}">
    <meta content="width=device-width,initial-scale=1,maximum-scale=1,minimal-ui" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black-translucent" name="apple-mobile-web-app-status-barstyle">
    <link href="assets/images/logo.svg" rel="apple-touch-icon">
    <meta content="Flatkit" name="apple-mobile-web-app-title">
    <meta content="yes" name="mobile-web-app-capable">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('resources/views/default/images/logo.png') }}" rel="shortcut icon" sizes="196x196">
    <link href="{{ asset('resources/views/default/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('resources/views/default/assets/css/app.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('resources/views/default/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/views/default/css/form.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body class="specialfont">
    <div class="header">
        <a href="{{ url('home') }}">
            <img width="30px" alt="." class="logo menulogo" src="{{ asset('resources/views/default/images/logo.png') }}">
        </a>
        <div class="logos">
            <text style="padding-left: 70px">
                <p class="Sea"><i class="fas fa-bars"></i></p>
            </text>
            <text>@yield('title', 'Autobot')</text>
            <ul class="nav flex-row order-lg-2">
                <li class="dropdown d-flex align-items-center">
                    <a class="d-flex align-items-center" data-toggle="dropdown" href="#">
                        <span class="avatar w-32" style="background-color: black;color: white;line-height: 0;">
                            <strong>{{ mb_strtoupper(mb_substr(Auth::user()->name, 0, 2)) }}</strong>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0 mt-2 animate fadeIn">
                        <a class="dropdown-item" href="{{ url('profile') }}">Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <li class="d-lg-none d-flex align-items-center"></li>
            </ul>
        </div>
    </div>
    <div class="sidebar">
        <ul class="mozhid">
            <li class="Dashboard">
                <a href="{{ url('home') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Dashboard">

                        <i style="padding-left:7px;" class="back sade fas fa-home"></i>
                        <span>Dashboard</span>
                    </div>
                    <div class="toolTips d-none">
                        <i style="padding-left:7px;" class="back sade fas fa-home"></i>
                        <span>Dashboard</span>

                    </div>
                </a>
            </li>
            <li class="Accounts">
                <a href="{{ url('accounts') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Accounts">

                        <i class="back sade fab fa-instagram"></i>
                        <span>Accounts</span>
                    </div>
                    <div class="toolTips d-none">

                        <i class="back sade fab fa-instagram"></i>
                        <span>Accounts</span>
                    </div>
                </a>
            </li>
            <li class="Calendar">
                <a href="{{ url('calendar') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Calendar">

                        <i class="back sade far fa-calendar-alt"></i>
                        <span>Calendar</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-calendar-alt"></i>
                        <span>Calendar</span>

                    </div>
                </a>
            </li>
            <li class="Captions">
                <a href="{{ url('captions') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Captions and More">

                        <i class="back sade far fa-check-square"></i>
                        <span>Captions and More</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade fas fa-vector-square"></i>
                        <span>Captions and More</span>

                    </div>
                </a>
            </li>
            <li class="Statistics">
                <a href="{{ url('statistics') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Statistics">

                        <i class="back sade far fa-chart-bar"></i>
                        <span>Statistics</span>
                    </div>
                    <div class="toolTips d-none">

                        <i class="back sade far fa-chart-bar"></i>
                        <span>Statistics</span>
                    </div>
                </a>
            </li>
            <li class="Schedule">
                <a href="{{ url('schedule-posts') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Systematic Posts">

                        <i class="back sade far fa-clock"></i>
                        <span>Systematic Posts</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-clock"></i>
                        <span>Systematic Posts</span>

                    </div>
                </a>
            </li>
            <li class="Follow">
                <a href="{{ url('auto-follow') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto Follow">

                        <i class="back sade far fa-user"></i>
                        <span>Auto Follow</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-user"></i>
                        <span>Auto Follow</span>

                    </div>
                </a>
            </li>
             <li class="Unfollow">
                <a href="{{ url('auto-unfollow') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto Unfollow">

                        <i class="back sade far fa-frown"></i>
                        <span>Auto Unfollow</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-frown"></i>
                        <span>Auto Unfollow</span>

                    </div>
                </a>
            </li>
            <li class="Like">
                <a href="{{ url('auto-like') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto Like">

                        <i class="back sade far fa-heart"></i>
                        <span>Auto Like</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-heart"></i>
                        <span>Auto Like</span>

                    </div>
                </a>
            </li>
            <li class="Comment">
                <a href="{{ url('auto-comment') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto Comment">

                        <i class="back sade far fa-comment-dots"></i>
                        <span>Auto Comment</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-comment-dots"></i>
                        <span>Auto Comment</span>

                    </div>
                </a>
            </li> 
            <li class="Repost">
                <a href="{{ url('auto-repost') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto Repost">

                        <i class="back sade fas fa-redo-alt"></i>
                        <span> Auto Repost</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade fas fa-redo-alt"></i>
                        <span> Auto Repost</span>

                    </div>
                </a>
            </li>
            <!-- <li class="Message">
                <a href="{{ url('auto-message') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto Direct Message">

                        <i class="back sade far fa-paper-plane"></i>
                        <span> Auto Direct Message</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-paper-plane"></i>
                        <span> Auto Direct Message</span>

                    </div>
                </a>
            </li> -->
            <li class="Dmtonew">
                <a href="{{ url('auto-dmtonew') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Auto DM to New Followers">

                        <i class="back sade far fa-envelope-open"></i>
                        <span> Auto DM to New Followers</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade far fa-envelope-open"></i>
                        <span> Auto DM to New Followers</span>

                    </div>
                </a>
            </li>
            
            @if(Auth::user()->role_id == 1)
            <hr>
            <li class="Users">
                <a href="{{ url('users') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Users">

                        <i class="back sade fas fa-user-friends"></i>
                        <span> Users</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade fas fa-user-friends"></i>
                        <span> Users</span>

                    </div>
                </a>
            </li>
            <li class="Proxies">
                <a href="{{ url('proxies') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Proxies">

                        <i class="back sade fas fa-server"></i>
                        <span> Proxies</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade fas fa-server"></i>
                        <span> Proxies</span>

                    </div>
                </a>
            </li>
            <li class="Systemstats">
                <a href="{{ url('systemstats') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="System Statistics">

                        <i class="back sade fas fa-chart-area"></i>
                        <span>System Statistics</span>
                    </div>
                    <div class="toolTips d-none">

                        <i class="back sade fas fa-chart-area"></i>
                        <span>System Statistics</span>
                    </div>
                </a>
            </li>
            <li class="Settings">
                <a href="{{ url('settings') }}">
                    <div class="toolTip" data-toggle="tooltip" data-placement="right" title="Configuration">

                        <i class="back sade fas fa-cog"></i>
                        <span> Configuration</span>
                    </div>
                    <div class="toolTips d-none">
                        <i class="back sade fas fa-cog"></i>
                        <span> Configuration</span>

                    </div>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <script>
        $('#menu-action').click(function() {
            $('.sidebar').toggleClass('active');
            $('.menulogo').toggleClass('addLogo');
            $('.toolTip').toggleClass('d-none');
            $('.toolTips').toggleClass('d-none');
            $(this).toggleClass('active');

            if ($('.sidebar').hasClass('active')) {
                $(this).find('i').addClass('fa-close');
                $(this).find('i').removeClass('fa-bars');
            } else {
                $(this).find('i').addClass('fa-bars');
                $(this).find('i').removeClass('fa-close');
            }
        });
        $('.Sea').click(function() {
            $('.sidebar').toggleClass('active');
            $('.toolTip').toggleClass('d-none');
            $('.toolTips').toggleClass('d-none');
            $(this).toggleClass('active');

        });
        // Add hover feedback on menu
        $('#menu-action').hover(function() {
            $('.sidebar').toggleClass('hovered');
        });
    </script>