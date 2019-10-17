@section('title', 'Auto DM to New Followers') @include('default/header')
<script>
    $(".Dmtonew a").addClass("activeSidebar");
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
                                <a href="{{ url('auto-dmtonew/'.$showaccounts->username) }}"><span class="w-40 avatar circle blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important"><!-- <img src='{{ asset("$showaccounts->profilepic") }}' alt='.'> -->
                                    {{ mb_strtoupper(mb_substr($showaccounts->username, 0, 2)) }}
                                </span></a>
                                <div class="list-body"><a href="{{ url('auto-dmtonew/'.$showaccounts->username) }}" class="item-title _500">{{ $showaccounts->username }}
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
                        <form method="POST" action="{{ url('updatedmtonew') }}">
                            @csrf
                            <input type="hidden" name="username" id="username" value="{{ $username }}">
                            <div class="box">
                                <label class="form-control myLabel">Auto DM to New Followers for <b>{{ $username }}</b></label>
                                <div class="box-body">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="caption" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Select a Caption Group</span>
                                                    @foreach($captiongroups as $showgroups)
                                                    {!! str_replace('value="'.$caption.'"','value="'.$caption.'" checked','
                                                        <label class="option bot">
                                                            <input type="radio" name="caption" value="'.$showgroups->groupname.'">
                                                            <span class="title animated fadeIn">'.$showgroups->groupname.'</span>
                                                        </label>') !!}
                                                    @endforeach
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
        @include('default/footer')