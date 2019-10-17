@section('title', 'Users') @include('default/header')
@if(Auth::user()->role_id != 1)
    @php 
        header("Location: home");
        exit;
    @endphp
@endif
<script>
    $(".Users a").addClass("activeSidebar");
</script>
<div class="content-main d-flex flex" id="L1">
    <div class="d-flex flex" id="L2">
        <div class="" id="L3">
            <div class="fade aside">
                <div class="d-flex flex-column w-xl b-r white modal-dialog">
                    <div class="scrollable hover">
                        <div class="list inset">
                            <div class="p-2 px-3 text-muted text-sm">
                                @if(isset($_GET['ok']))
                                <div class="alert alert-success" role="alert">User deleted successfully.</div>
                                @endif
                                @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                Select a user
                            </div>
                            @if(!empty($users)) @foreach($users as $showusers)
                            <div class="list-item"><a href="{{ url('users/'.$showusers->id) }}"><span class="avatar w-32" style="background-color: black;color: white;line-height: 0"><strong>{{ mb_strtoupper(mb_substr($showusers->name, 0, 2)) }}</strong></span>
                                <div class="list-body"><div class="item-title _500">{{ $showusers->name }}</div>
                                    <div class="item-except text-sm text-muted h-1x" style="font-weight:400">Reg date: @php $explode = explode(" ", $showusers->created_at); echo $explode[0]; @endphp</div>
                                    <div class="item-except text-sm text-muted h-1x" style="font-weight:400">Member type: {{ $showusers->role_id == 1 ? 'Admin' : 'Regular User' }}</div></a>
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
            @if(!empty($users)) @if(empty($edituser))
            <div class="aside-sm middletext">Please select a user from left side list.</div>
            @else
            <div class="content-main d-flex flex zero" id="content-main">
                <div class="d-flex flex" data-plugin="chat">
                    <div class="col-sm">
                        <form method="POST" action="{{ url('updateuser') }}">
                            @csrf
                            <input type="hidden" name="currentemail" value="{{ $email }}">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="box">
                                <label class="form-control myLabel">View account details for <b>{{ $name }}</b>
                                    <div class="text-right" style="margin-top: -19px"><button style="background: transparent;border:0px;padding: 0px" type="button" data-toggle="modal" data-target="#m-a-a" data-toggle-class="fade-down" data-toggle-class-target="#animate">Delete this user</button></div>
                                </label>
                                <div class="box-body">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-style-7">
                                                <ul>
                                                    <li>
                                                        <label for="caption">Name</label>
                                                        <input type="text" name="name" value="{{ $name }}" required="">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-style-7">
                                                <ul>
                                                    <li>
                                                        <label for="caption">Email</label>
                                                        <input type="text" name="email" value="{{ $email }}" required="">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><p><br>
                                    
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-style-7">
                                                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                                    <ul>
                                                        <li>
                                                            <label for="new-password">New Password</label>
                                                            <input id="new-password" type="password" name="new-password">
                                                        </li>
                                                    </ul> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-style-7">
                                                <div class="form-group">
                                                    <ul>
                                                        <li>
                                                            <label for="new-password-confirm">Confirm New Password</label>
                                                            <input id="new-password-confirm" type="password" name="new-password_confirmation">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('new-password'))
                                        <div class="alert alert-danger" style="width: 100%;max-width: 100%;text-align: center;font-size: 12px">{{ $errors->first('new-password') }}</div><p><br>
                                    @endif
                                    
                                    <div class="form-style-7">
                                        <ul>
                                            <li style="border: 0!important;box-shadow: none!important;padding-top: 3px">
                                                <span>If you don't want to change password, leave it blank these password fields!</span>
                                            </li>
                                        </ul>
                                    </div><p><br>

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="accounttype" value="0" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Account Type</span>
                                                    {!! str_replace('value="'.$accounttype.'"','value="'.$accounttype.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="accounttype" value="0">
                                                        <span class="title animated fadeIn">Regular User</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="accounttype" value="1">
                                                        <span class="title animated fadeIn">Admin</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="status" value="1" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Status</span>
                                                    {!! str_replace('value="'.$status.'"','value="'.$status.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="status" value="1">
                                                        <span class="title animated fadeIn">Active</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="status" value="0">
                                                        <span class="title animated fadeIn">Deactive</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary specialbutton mainbutton">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="m-a-a" class="modal fade" data-backdrop="true">
                            <div class="modal-dialog animate" id="animate">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete this user {{ $name }}!</h5></div>
                                    <div class="modal-body text-center p-lg">
                                        <p>Are you sure to delete this user?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark-white p-x-md modbtn" data-dismiss="modal">No</button>
                                        <a href="{{ url('deleteuser/'.$id) }}" class="btn danger p-x-md modbtn">Yes</a>
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