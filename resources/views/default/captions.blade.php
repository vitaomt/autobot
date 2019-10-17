@section('title', 'Caption Groups') @include('default/header')
<script>
    $(".Captions a").addClass("activeSidebar");
</script>
<div class="col-md-12 content-main">
    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a class="nav-link active linkone" href="{{ url('captions') }}" style="height: 57px;">
                <div>
                    <i class="far fa-plus-square" style="font-size: 22px"></i>
                    <div class="type">
                        <div class="blocks">
                            <span class="name1">Captions</span>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link linktwo" href="{{ url('comments') }}" style="height: 57px;">
                <div>
                    <i class="fas fa-comment-dots" style="font-size: 22px"></i>
                    <div class="type">
                        <div class="blocks">
                            <span class="name1">Comments</span>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link linkthree" href="{{ url('blacklists') }}" style="height: 57px;">
                <div>
                    <i class="fas fa-user-lock" style="font-size: 22px"></i>
                    <div class="type">
                        <div class="blocks">
                            <span class="name1">Blacklists</span>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>
<div class="content-main d-flex flex" id="L1">
    <div class="d-flex flex" id="L2">
        <div id="L3">
            <div class="fade aside">
                <div class="d-flex flex-column w-xl b-r white modal-dialog">
                    <div class="scrollable hover">
                        <div class="list inset">
                            <div class="list-item">
                                <a href="{{ url('captions') }}" class="btn btn-primary specialbutton mainbutton">Add new caption</a>
                            </div>
                            <div class="p-2 px-3 text-muted text-sm">
                                @if(isset($_GET['ok']))
                                <div class="alert alert-success" role="alert">Comment added successfully.</div>
                                @elseif(isset($_GET['fail']))
                                <div class="alert alert-danger" role="alert">Group name can not be empty.</div>
                                @endif
                                Select a group
                            </div>
                            @if(!empty($groups)) @foreach($groups as $showgroups)
                            <div class="list-item">
                                <a href="{{ url('captions/'.$showgroups->groupname) }}">
                                    <span class="avatar w-32" style="background-color: black;color: white;line-height: 0">
                                        <strong>{{ mb_strtoupper(mb_substr($showgroups->groupname, 0, 2)) }}</strong>
                                    </span>
                                </a>
                                <div class="list-body" style="margin-top: 5px">
                                    <a href="{{ url('captions/'.$showgroups->groupname) }}" class="item-title _500">{{ $showgroups->groupname }}</a>
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
        @if(empty($edituser))
            <div class="content-main d-flex flex zero" id="content-main">
                <div class="d-flex flex" data-plugin="chat">
                    <div class="col-sm">
                        <form method="POST" action="{{ url('addcaption') }}">
                            @csrf
                            <div class="box">
                                <label class="form-control myLabel">Add new Caption Groups</label>
                                <div class="box-body">                                        

                                    <div class='input-group mb-3'>
                                        <div class="select animated zoomIn">
                                            <input type="radio" name="groupselect" value="" required="">
                                            <i class="toggle icon icon-arrow-down"></i>
                                            <i class="toggle icon icon-arrow-up"></i>
                                            <span class="placeholder">Select a group</span>
                                            <label class="option bot">
                                                <input type="radio" name="groupselect" value="newgroup">
                                                <span class="title animated fadeIn">Add new group</span>
                                            </label>
                                            @foreach($groups as $showgroups)
                                                <label class="option bot">
                                                    <input type="radio" name="groupselect" value="{{ $showgroups->groupname }}">
                                                    <span class="title animated fadeIn">{{ $showgroups->groupname }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div><br>

                                    <div class="form-style-7" style="width: 100%;max-width: 100%">
                                        <ul>
                                            <div id="ifYes" style="display: none;">
                                                <li>
                                                    <label>Group Name</label>
                                                    <input type="text" name="groupname" value="" id='explicit-block-txt' autocomplete="off" onpaste="return false"/></input>
                                                    <span>Enter a group name for captions.</span>
                                                </li><br>
                                            </div>
                                            <li>
                                                <label>Caption</label>
                                                <input type="text" required="" name="caption" value="" autocomplete="off"></input>
                                                <span>Enter a caption with #hashtags.</span>
                                            </li>
                                        </ul>
                                    </div><p><br>

                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary specialbutton specialsmall mainbutton">Add caption</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="content-main d-flex flex zero" id="content-main">
                <div class="d-flex flex" data-plugin="chat">
                    <div class="col-sm">
                        <form method="POST" action="{{ url('editgroup') }}">
                            @csrf
                            <input type="hidden" name="groupid" value="{{ $groupid }}">
                            <div class="box">
                                <label class="form-control myLabel">Manage captions for <b>{{ $edituser }}</b><div class="text-right" style="margin-top: -19px"><button style="background: transparent;border:0px;padding: 0px" type="button" data-toggle="modal" data-target="#m-a-a" data-toggle-class="fade-down" data-toggle-class-target="#animate">Delete this group</button></b></div></label>
                                
                                <div class="box-body">

                                    <div class="form-style-7" style="width: 100%;max-width: 100%">
                                        <ul>
                                            
                                            <li>
                                                <label>Edit Group Name</label>
                                                <input type="text" name="groupname" id='explicit-block-txt' value="{{ $edituser }}" autocomplete="off" onpaste="return false"/></input>
                                                <span>If you want, you can change this group name.</span>
                                            </li>
                                        </ul>
                                    </div><p><br>

                                    <div class="text-left">
                                        <button type="submit" class="btn btn-primary specialbutton specialsmall mainbutton">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if(!empty($list))
                        <div class="box">
                            <div class="box-body">
                                <div class="text-left">
                                    @foreach($list as $showlist)
                                    <p>
                                        <div style="text-align: left" class="btn btn-secondary btn-sm">{{ $showlist->caption }} <a href="{{ url('deletecaption/'.$edituser.'/'.$showlist->id) }}"><i class="fas fa-times"></i></a></div>
                                    </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                        <div id="m-a-a" class="modal fade" data-backdrop="true">
                            <div class="modal-dialog animate" id="animate">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete {{ $edituser }} group!</h5></div>
                                    <div class="modal-body text-center p-lg">
                                        <p>Are you sure to delete this group?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark-white p-x-md modbtn" data-dismiss="modal">No</button>
                                        <a href="{{ url('deletegroup/'.$edituser) }}" class="btn danger p-x-md modbtn">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<script type="text/javascript">
    document.getElementById("explicit-block-txt").onkeypress = function(e) {
        var chr = String.fromCharCode(e.which);
        if ("></\"".indexOf(chr) >= 0)
            return false;
    };
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('input[type="radio"]').click(function() {
       if($(this).attr('value') == 'newgroup') {
            $('#ifYes').show('slow');           
       }
       else {
            $('#ifYes').hide('slow');   
       }
    });
});
</script>
@include('default/footer')