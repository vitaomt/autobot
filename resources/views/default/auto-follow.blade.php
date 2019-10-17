@section('title', 'Auto Follow') @include('default/header')
<script>
    $(".Follow a").addClass("activeSidebar");
</script>
<div class="content-main d-flex flex" id="L1">
    <div class="d-flex flex" id="L2">
        <div id="L3">
            <div class="fade aside">
                <div class="d-flex flex-column w-xl b-r white modal-dialog">
                    <div class="scrollable hover">
                        <div class="list inset">
                            @if(!empty($accounts)) @foreach($accounts as $showaccounts)
                            <div class="list-item">
                                <a href="{{ url('auto-follow/'.$showaccounts->username) }}"><span class="w-40 avatar circle blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important"><!-- <img src='{{ asset("$showaccounts->profilepic") }}' alt='.'> -->
                                    {{ mb_strtoupper(mb_substr($showaccounts->username, 0, 2)) }}
                                </span></a>
                                <div class="list-body"><a href="{{ url('auto-follow/'.$showaccounts->username) }}" class="item-title _500">{{ $showaccounts->username }}
                                    <div class="item-except text-sm text-muted h-1x" style="font-weight:400">Instagram account</div></a>
                                    <div class="item-tag tag hide"></div>
                                </div>
                            </div>
                            @endforeach @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="L4">
            @if(empty($accounts))
            <div class="aside-sm middletext">You haven't add any Instagram account yet.
                <br> Click the button below to add your first account.
                <p>
                    <br>
                    <a href="newaccount" class="btn btn-primary specialbutton middle">New account</a>
            </div>
            @endif @if(!empty($accounts)) @if(empty($edituser))
            <div class="aside-sm middletext">Please select an account from left side list.</div>
            @else
            <div class="content-main d-flex flex zero" id="content-main">
                <div class="d-flex flex" data-plugin="chat">
                    <div class="col-sm">
                        @if(isset($_GET['ok']))
                        <div class="alert alert-success" role="alert">Settings updated successfuly..</div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="box text-center" style="max-height: 235px;min-height: 235px;">
                                    <div class="p-4">
                                        <p><center><div class="circle w-56 avatar circle blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important">{{ mb_strtoupper(mb_substr($username, 0, 2)) }}</div></center></p>
                                        <div class="text-md d-block">{{ $username }}</div>
                                        <p><small><a href="https://www.instagram.com/{{$username}}" target="_blank">View on Instagram</a></small></p>
                                        <p><small>{{ $about }}</small></p>
                                        <a href="{{ url('logs/'.$username) }}" class="btn btn-sm btn-outline btn-rounded b-accent">Show Action Logs</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="box text-center" style="max-height: 235px;min-height: 235px;">
                                    <div class="p-4" style="padding: 2.5rem!important">
                                        @if($private == 1)
                                        <p><i class="fas fa-lock" style="padding: 17px;font-size: 22px;color: white;background: #dbdbdb;border-radius: 35px;"></i></p>
                                        @else
                                        <p><i class="fas fa-lock-open" style="padding: 17px;font-size: 22px;color: white;background: #dbdbdb;border-radius: 35px;"></i></p>
                                        @endif
                                        <p><div class="text-md d-block">Private Account</div></p><p>
                                        <form method="post" action="{{ url('privateaccount') }}" onchange="this.form.submit()">
                                        @csrf
                                        <input type="hidden" name="username" value="{{ $username }}">
                                            <label class="switch">
                                                {!! str_replace('value="'.$private.'"','value="'.$private.'" checked','
                                                <input type="checkbox" name="privateaccount" value="1" onchange="this.form.submit()">') !!}
                                                <span class="slider round"></span>
                                            </label>
                                        </form>
                                    </div>
                                    <!-- <div class="row row-col no-gutters b-t rounded-bottom text-center">
                                        <div class="col-4 b-r">
                                            <a href="#" class="py-3 d-block" data-toggle-class=""><strong class="d-block">{{ $mediacount }}</strong> <span class="d-block">Posts</span>
                                            </a>
                                        </div>
                                        <div class="col-4 b-r">
                                            <a href="#" class="py-3 d-block" data-toggle-class=""><strong class="d-block">{{ $followercount }}</strong> <span class="d-block">Followers</span>
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <a href="#" class="py-3 d-block" data-toggle-class=""><strong class="d-block">{{ $followingcount }}</strong> <span class="d-block">Followings</span>
                                            </a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ url('updatefollow') }}">
                            @csrf
                            <input type="hidden" name="username" id="username" value="{{ $username }}">
                            <div class="box">
                                <label class="form-control myLabel">Auto Follow for <b>{{ $username }}</b></label>
                                <div class="box-body">

                                    <div class="form-style-7" style="width: 100%;max-width: 100%">
                                        <ul>
                                            <li>
                                                <label>Target</label>
                                                <input type="text" autocomplete="off" name="" id="search">
                                                <span>Enter username, for Hashtags please use #</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div id="autoCompleteContainer" style="max-height: 140px; overflow-x: auto; margin-top: 10px; box-shadow: 0 1px 30px 0 rgba(212,212,233,.5)!important; font-size: 15px"></div>

                                    <div id="loadingContainer">
                                        <center><img style="z-index:11;max-width: 30px; visibility: hidden; position: absolute;" id="loading" src="{{ asset('resources/views/default/images/loading.gif') }}"></center>
                                    </div>
                                    <br>

                                    <div class="input-group">
                                        <div class="col-sm" id="spanInsertUsername">
                                            @if(!empty($target)) @foreach(explode(" ", $target) as $showtarget)
                                            <span class="badge badge-dark">{{ $showtarget }} &nbsp; @php $target = str_replace("#", "$", $showtarget); @endphp <a href="{{ url('deletetarget/'.$username.'/follow/'.$target) }}"><i class="fas fa-times"></i></a></span> @endforeach @endif
                                            <input type="text" name="target" id="target" hidden value="{{ $target }}">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="inputGroup form">
                                                {!! str_replace("value='".$tofollowers."'","value='".$tofollowers."' checked","
                                                <input id='option1' name='tofollowers' value='1' type='checkbox'/>") !!}
                                                <label for="option1">Follow selected user's followers</label>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="inputGroup form">
                                                {!! str_replace("value='".$tofollowings."'","value='".$tofollowings."' checked","
                                                <input id='option2' name='tofollowings' value='1' type='checkbox'/>") !!}
                                                <label for="option2">Follow selected user's followings</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="accountphoto" value="any" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Profile Photo</span>
                                                    {!! str_replace('value="'.$accountphoto.'"','value="'.$accountphoto.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="accountphoto" value="any">
                                                        <span class="title animated fadeIn">Any</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="accountphoto" value="true">
                                                        <span class="title animated fadeIn">If has profile photo</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="accountphoto" value="false">
                                                        <span class="title animated fadeIn">If hasn\'t profile photo</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="accountstatus" value="any" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Account Status</span>
                                                    {!! str_replace('value="'.$accountstatus.'"','value="'.$accountstatus.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="accountstatus" value="any">
                                                        <span class="title animated fadeIn">Any</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="accountstatus" value="true">
                                                        <span class="title animated fadeIn">Public</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="accountstatus" value="false">
                                                        <span class="title animated fadeIn">Private</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>

                                    <div class="form-style-7" style="width: 100%;max-width: 100%">
                                        <ul>
                                            <li>
                                                <label>Like</label>
                                                <input type="number" name="photolike" value="{{ $photolike }}" max="5" autocomplete="off"></input>
                                                <span>Like last "X quantity" photos of followed user. We recommend 1-2. Leave it blank for deactivate.</span>
                                            </li>
                                            <li>
                                                <label>Follower Count</label>
                                                <input type="number" name="botdetect" value="{{ $botdetect }}" autocomplete="off">
                                                <span>If user's follower quantity less than XX don't follow and continue another user. Leave it blank for deactivate.</span>
                                            </li>
                                            <li>
                                                <label>Media Count</label>
                                                <input type="number" name="botdetect2" value="{{ $botdetect2 }}" autocomplete="off">
                                                <span>If user's media count less than XX don't follow and continue another user. Leave it blank for deactivate.</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <p><br>

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="blacklist" value="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Select a Blacklist Group</span>
                                                    <label class="option bot">
                                                        <input type="radio" name="blacklist" value="">
                                                        <span class="title animated fadeIn">Don't use blacklist</span>
                                                    </label>
                                                    @foreach($blacklistgroups as $showgroups)
                                                    {!! str_replace('value="'.$blacklist.'"','value="'.$blacklist.'" checked','
                                                        <label class="option bot">
                                                            <input type="radio" name="blacklist" value="'.$showgroups->groupname.'">
                                                            <span class="title animated fadeIn">'.$showgroups->groupname.'</span>
                                                        </label>') !!}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="speed" value="auto" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Select a Speed</span>
                                                    {!! str_replace('value="'.$speed.'"','value="'.$speed.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="speed" value="auto">
                                                        <span class="title animated fadeIn">Auto (Recommended)</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="speed" value="veryslow">
                                                        <span class="title animated fadeIn">Very Slow</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="speed" value="slow">
                                                        <span class="title animated fadeIn">Slow</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="speed" value="medium">
                                                        <span class="title animated fadeIn">Medium</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="speed" value="fast">
                                                        <span class="title animated fadeIn">Fast</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="speed" value="veryfast">
                                                        <span class="title animated fadeIn">Very Fast (Risk)</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="status" value="0" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Select a Status</span>
                                                    {!! str_replace('value="'.$status.'"','value="'.$status.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="status" value="0">
                                                        <span class="title animated fadeIn">Deactive</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="status" value="1">
                                                        <span class="title animated fadeIn">Active</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="alert alert-danger" role="alert">We strongly recommend using the speed option as "Auto". With this option, process time changes automatically according to your account status, so that instagram does not detect your account as a bot. This process may be a bit slow, but remember! Extremely safe.</div> -->
                                    <div class='input-group mb-3'>                                        
                                        <div class="text-right">
                                            <br>
                                            <button type="submit" class="btn btn-primary specialbutton specialsmall mainbutton">Save</button>
                                        </div>
                                    </div>
                        </form>
                        </div>
                        </div>
                    </div>
                </div>
                @endif @endif
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />
        <script type="text/javascript">
            $(function() {
                $('.selectpicker').selectpicker();
            });
        </script>

        <script type="text/javascript">
            $(function() {

                $("#search").keyup(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var search = document.getElementById('search').value
                    var username = document.getElementById('username').value

                    $('#loading').css('visibility', 'visible');

                    if (search.charAt(0) === "#") {
                        $.ajax({
                            type: "POST",
                            url: '{{ url("ajaxRequestH") }}',
                            //dataType: "html",
                            data: {
                                query: search,
                                usernm: username
                            },

                            success: function(data) {
                                // show the response
                                // $("#autoCompleteContainer").html($(data).find("#timeonpage"));
                                $('#autoCompleteContainer').html(data);
                                $('#loading').css('visibility', 'hidden');

                                // console.log(data);

                            }
                        });
                    } else {

                        $.ajax({
                            type: "POST",
                            url: '{{ url("ajaxRequestU") }}',
                            //dataType: "html",
                            data: {
                                query: search,
                                usernm: username
                            },

                            success: function(data) {
                                // show the response
                                // $("#autoCompleteContainer").html($(data).find("#timeonpage"));
                                $('#autoCompleteContainer').html(data);
                                $('#loading').css('visibility', 'hidden');
                                // console.log(data);

                            }
                        });
                    }

                });

            });
        </script>

        <script>
            $(document).on('click', '.getUsername', function() {
                var uname = $(this).text();
                // alert(url);

                // empty value on clickc
                document.getElementById('search').value = "";
                document.getElementById('autoCompleteContainer').innerHTML = "";

                $('#spanInsertUsername').prepend('<span class="badge badge-dark">' + uname + '</span>&nbsp; ');

                var unameInput = document.getElementById('target').value = document.getElementById('target').value + uname;
            });
        </script>

        @include('default/footer')