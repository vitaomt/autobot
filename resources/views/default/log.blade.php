@section('title', 'System Logs') @include('default/header')
<div class="content-main" id="content-main">
    <div>
        <div class="d-sm-flex">
            <div class="" id="L3">
                <div class="fade aside">
                    <div class="d-flex flex-column w-xl b-r white modal-dialog">
                        <div class="scrollable hover">
                            <div class="list inset">
                                @if(!empty($accounts)) @foreach($accounts as $showaccounts)
                                <div class="list-item">
                                    <a href="{{ url('logs/'.$showaccounts->username) }}"><span class="w-40 avatar circle blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important"><!-- <img src='{{ asset("$showaccounts->profilepic") }}' alt='.'> -->
                                    {{ mb_strtoupper(mb_substr($showaccounts->username, 0, 2)) }}
                                </span></a>
                                    <div class="list-body"><a href="{{ url('logs/'.$showaccounts->username) }}" class="item-title _500">{{ $showaccounts->username }}
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
                            <div class="b-b b-primary nav-active-primary">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-target="#tab-1" data-toggle="tab" href="#">Follow</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-2" data-toggle="tab" href="#">Unfollow</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-3" data-toggle="tab" href="#">Like</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-4" data-toggle="tab" href="#">Comment</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-5" data-toggle="tab" href="#">Repost</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-6" data-toggle="tab" href="#">Direct Message</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-7" data-toggle="tab" href="#">DM to New</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-8" data-toggle="tab" href="#">Schedule</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-target="#tab-9" data-toggle="tab" href="#">Error Logs</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col p-0">
                                <div class="tab-content pos-rlt">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($followlogs)) @foreach($followlogs as $showlog)
                                                    @php $followlog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <!-- <span class="w-40 avatar circle light-blue" style="background-image: url({{ $followlog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover">
                                                            </span> -->
                                                            <a href="https://www.instagram.com/{{ $followlog->{'username'} }}" target="_blank"><span class="w-40 avatar circle light-blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important">
                                                                {{ mb_strtoupper(mb_substr($followlog->{'username'}, 0, 2)) }}
                                                            </span></a>
                                                            <div class="list-body" style="margin-top: 8px;"><div class="item-title _500">{{ $followlog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <a href="https://www.instagram.com/{{ $followlog->{'username'} }}" target="_blank"><div class="item-except text-sm text-muted h-1x">{{ $followlog->{'target'} }} {{ $followlog->{'username'} }}</div></a>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/{{ $followlog->{'username'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Profile</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $followlogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto Follow activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-2">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($unfollowlogs)) @foreach($unfollowlogs as $showlog)
                                                    @php $unfollowlog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="background-image: url({{ $unfollowlog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover"></span>
                                                            <div class="list-body" style="margin-top: 20px;"><div class="item-title _500">{{ $unfollowlog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x"></div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/{{ $unfollowlog->{'username'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Profile</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $unfollowlogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto Unfollow activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-3">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($likelogs)) @foreach($likelogs as $showlog)
                                                    @php $likelog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <!-- <span class="w-40 avatar circle light-blue" style="background-image: url({{ $likelog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover"></span> -->
                                                            <a href="https://www.instagram.com/p/{{ $likelog->{'link'} }}" target="_blank"><span class="w-40 avatar circle light-blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important">
                                                                {{ mb_strtoupper(mb_substr($likelog->{'target'}, 0, 2)) }}
                                                            </span></a>
                                                            <div class="list-body" style="margin-top: 8px;"><div class="item-title _500">{{ $likelog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x">{{ $likelog->{'target'} }}</div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/p/{{ $likelog->{'link'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Post</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $likelogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto Like activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-4">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($commentlogs)) @foreach($commentlogs as $showlog)
                                                    @php $commentlog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="background-image: url({{ $commentlog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover"></span>
                                                            <div class="list-body" style="margin-top: 8px;"><div class="item-title _500">{{ $commentlog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x">{{ $commentlog->{'target'} }}</div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/p/{{ $commentlog->{'code'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Post</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $commentlogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto Comment activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-5">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($repostlogs)) @foreach($repostlogs as $showlog)
                                                    @php $repostlog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="background-image: url({{ $repostlog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover"></span>
                                                            <div class="list-body" style="margin-top: 8px;"><div class="item-title _500">{{ $repostlog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x">{{ $repostlog->{'target'} }}</div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/p/{{ $repostlog->{'code'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Post</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $repostlogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto Repost activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-6">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($messagelogs)) @foreach($messagelogs as $showlog)
                                                    @php $messagelog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="background-image: url({{ $messagelog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover"></span>
                                                            <div class="list-body" style="margin-top: 8px;"><div class="item-title _500">{{ $messagelog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x">{{ $messagelog->{'target'} }}</div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/{{ $messagelog->{'username'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Profile</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $messagelogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto Direct Message activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-7">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($dmtonewlogs)) @foreach($dmtonewlogs as $showlog)
                                                    @php $dmtonewlog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="background-image: url({{ $dmtonewlog->{'ppic'} }});width: 60px;height: 60px;background-position: center;background-size: cover"></span>
                                                            <div class="list-body" style="margin-top: 20px;"><div class="item-title _500">{{ $dmtonewlog->{'text'} }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x"></div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                            <a href="https://www.instagram.com/{{ $dmtonewlog->{'username'} }}" target="_blank" style="margin-top: 12px;margin-bottom: 10px;border: 1px solid #e0e0e0;padding: 8px;color: #9b9b9b;"><span class="item-date text-xs text-muted">View Profile</span></a>
                                                        </div>
                                                    @endforeach
                                                        {{ $dmtonewlogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Auto DM to New activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-8">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($schedulelogs)) @foreach($schedulelogs as $showlog)
                                                    @php $schedulelog = json_decode($showlog->log) @endphp
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="width: 60px;height: 60px">SC</span>
                                                            <div class="list-body" style="margin-top: 20px;"><div class="item-title _500">Media shared successfully | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x"></div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                        {{ $schedulelogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Schedule Post activity log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-9">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3>Logs for {{ $username }}</h3>
                                            </div>
                                            <div class="box-divider m-0"></div>
                                            <div class="list">
                                                <div class="jscroll-inner">
                                                    @if(!empty($errorlogs)) @foreach($errorlogs as $showlog)
                                                        <div class="list-item" data-id="item-2">
                                                            <span class="w-40 avatar circle light-blue" style="width: 60px;height: 60px">E</span>
                                                            <div class="list-body" style="margin-top: 20px;"><div class="item-title _500">{{ $showlog->log }} | <small> {{ $showlog->date }}</small></div>
                                                                <div class="item-except text-sm text-muted h-1x"></div>
                                                                <div class="item-tag tag hide"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                        {{ $errorlogs->links() }}
                                                    @else
                                                        <div style="text-align: center;padding: 20px">Error log is empty.</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@include('default/footer')