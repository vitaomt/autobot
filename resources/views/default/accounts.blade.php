@section('title', 'Accounts') @include('default/header')

<script>
    $(".Accounts a").addClass("activeSidebar");
</script>
<div class="content-main d-flex flex" id="L1">
    <div class="d-flex flex" id="L2">
        <div class="" id="L3">
            <div class="fade aside">
                <div class="d-flex flex-column w-xl b-r white modal-dialog">
                    <div class="scrollable hover">
                        <div class="list inset">
                            <div class="list-item">
                                <a href="{{ url('newaccount') }}" class="btn btn-primary specialbutton mainbutton">Add new account</a>
                            </div>
                            <div class="p-2 px-3 text-muted text-sm">
                                @if(isset($_GET['ok']))
                                <div class="alert alert-success" role="alert">Your account has been queued to be added. It can take up to 5 minutes for your account to appear in the accounts section! If you don't see your account after this time, repeat the process, you may have entered the code incorrectly or late.</div>
                                @endif Select an account
                            </div>
                            @if(!empty($accounts)) @foreach($accounts as $showaccounts)
                            <div class="list-item">
                                <a href="{{ url('accounts/'.$showaccounts->username) }}"><span class="w-40 avatar circle blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important"><!-- <img src='{{ asset("$showaccounts->profilepic") }}' alt='.'> -->
                                    {{ mb_strtoupper(mb_substr($showaccounts->username, 0, 2)) }}
                                </span>
                                <div class="list-body"><a href="{{ url('accounts/'.$showaccounts->username) }}" class="item-title _500">{{ $showaccounts->username }}
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
                    <div class="col-sm-7">
                        @if(isset($_GET['proxyok']))
                        <div class="alert alert-success" role="alert">Proxy update procedure is successful..</div>
                        @endif
                        <form method="POST" action="{{ url('updateproxy') }}">
                            @csrf
                            <input type="hidden" name="username" value="{{ $username }}">
                            <div class="box">
                                <label class="form-control myLabel">Edit <b>{{ $username }}</b></label>
                                <div class="box-body">
                                    @if($query->{'ownproxy'} == 1)
                                        <div class="form-group">
                                            <div class="form-style-7">
                                                <ul>
                                                    <li>
                                                        <label for="caption">Proxy</label>
                                                        <input type="text" name="proxy" value="{{ $proxy }}" maxlength="500" autocomplete="off">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="form-group" style="font-size:12px">
                                            <li>Proxy should match following pattern: http://ip:port OR http://username:password@ip:port</li>
                                            <li>It's recommended to to use a proxy belongs to the country where you've logged in this acount in Instagram's official app or website.</li>
                                        </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary specialbutton mainbutton">Save</button>
                                    </div>
                                    @else
                                        <div class="form-group" style="font-size:12px">
                                            <li>Sorry, proxy settings deactivated by admin.</li>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="box">
                            <div class="box-body">
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger specialbuttondanger mainbutton" data-toggle="modal" data-target="#m-a-a" data-toggle-class="fade-down" data-toggle-class-target="#animate">Delete this account</button>

                                    <div id="m-a-a" class="modal fade" data-backdrop="true">
                                        <div class="modal-dialog animate" id="animate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete {{ $username }}!</h5></div>
                                                <div class="modal-body text-center p-lg">
                                                    <p>Are you sure to delete this account?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark-white p-x-md modbtn" data-dismiss="modal">No</button>
                                                    <a href="{{ url('deleteaccount/'.$username) }}" class="btn danger p-x-md modbtn">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif @endif
    </div>

</div>
@include('default/footer')