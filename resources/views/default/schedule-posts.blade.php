@section('title', 'Systematic Schedule Posts') @include('default/header')
<script>
    $(".Schedule a").addClass("activeSidebar");
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
                                <a href="{{ url('schedule-posts/'.$showaccounts->username) }}"><span class="w-40 avatar circle blue" style="background: linear-gradient(to right, #667eea, #764ba2)!important"><!-- <img src='{{ asset("$showaccounts->profilepic") }}' alt='.'> -->
                                    {{ mb_strtoupper(mb_substr($showaccounts->username, 0, 2)) }}
                                </span></a>
                                <div class="list-body"><a href="{{ url('schedule-posts/'.$showaccounts->username) }}" class="item-title _500">{{ $showaccounts->username }}
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
                        <div class="alert alert-success" role="alert">Schedule settings update procedure is successful..</div>
                        @endif
                        <div class="box">
                            <div class="box-body">
                                <form method="post" action="{{ url('photo-upload') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="username" value="{{ $username }}">
                                    <input type="file" style="width: 90%;height: 35px" id="real-input" name="photo[]" multiple="" onchange="javascript:this.form.submit();">
                                    <div class="br15" style="background: #f5f7fb!important; border:0; width: 100%;;padding-bottom: 3px;margin-bottom: 15px;text-align: center">
                                        <i class="uploadp fas fa-cloud-upload-alt"></i>
                                    </div>
                                </form>
                                <form method="POST" action="{{ url('updateschedule') }}">
                                    @csrf
                                    <input type="hidden" name="username" value="{{ $username }}">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="time" value="auto" required="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Select a Speed</span>
                                                    {!! str_replace('value="'.$time.'"','value="'.$time.'" checked','
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="3600">
                                                        <span class="title animated fadeIn">Every hour (Don\'t recommend)</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="10800">
                                                        <span class="title animated fadeIn">Every 3 hours</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="21600">
                                                        <span class="title animated fadeIn">Every 6 hours</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="43200">
                                                        <span class="title animated fadeIn">Every 12 hours</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="86400">
                                                        <span class="title animated fadeIn">Every day</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="259200">
                                                        <span class="title animated fadeIn">Every 3 days</span>
                                                    </label>
                                                    <label class="option bot">
                                                        <input type="radio" name="time" value="604800">
                                                        <span class="title animated fadeIn">Every week</span>
                                                    </label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class='input-group mb-3'>
                                                <div class="select animated zoomIn">
                                                    <input type="radio" name="captiongroup" value="">
                                                    <i class="toggle icon icon-arrow-down"></i>
                                                    <i class="toggle icon icon-arrow-up"></i>
                                                    <span class="placeholder">Select a Caption Group</span>
                                                    <label class="option bot">
                                                        <input type="radio" name="captiongroup" value="">
                                                        <span class="title animated fadeIn">Don't use Caption</span>
                                                    </label>
                                                    @foreach($groups as $showgroups)
                                                    {!! str_replace('value="'.$captiongroup.'"','value="'.$captiongroup.'" checked','
                                                        <label class="option bot">
                                                            <input type="radio" name="captiongroup" value="'.$showgroups->groupname.'">
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

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="inputGroup form">
                                                {!! str_replace("value='".$deletephoto."'","value='".$deletephoto."' checked","
                                                <input id='option1' name='deletephoto' value='1' type='checkbox'/>") !!}
                                                <label for="option1">Delete photo from gallery after share</label>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="inputGroup form">
                                                {!! str_replace("value='".$random."'","value='".$random."' checked","
                                                <input id='option2' name='random' value='1' type='checkbox'/>") !!}
                                                <label for="option2">Random photo share from gallery</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='input-group mb-3'>
                                        <div class="text-right">
                                            <button type="submit" style="position: absolute;right: 0px;width: 20%;height: 0" class="btn btn-primary specialbutton">Save</button>
                                        </div>
                                    </div>
                                </form><p><br>

                                    <br> @if(!empty($photocheck))
                                    <div class="row row-xs">
                                        @foreach ($photos as $photo)
                                        <div class="col-6 col-sm-3 col-md-2">
                                            <div style="width: 143px!important; height: 143px;border-radius: 0px" class="box p-1 hoveri hoverimg"><a href="{{ url('photodelete/'.$edituser.'/'.$photo->id) }}"><i style="position: absolute;right: 5px;top: 10px;border: 1px solid #627384;padding: 5px;border-radius: 100px;background: #e5e6e8;z-index: 1000" class="fas fa-trash-alt"></i></a>
                                                <a href="{{ asset('storage/app/photos/'.$photo->user_id) }}/{{ $photo->photo }}" target="_blank"><img src="{{ asset('storage/app/photos/'.$photo->user_id) }}/{{ $photo->photo }}" style="width: auto!important; height: 141px" class="w-100"></a>
                                            </div>
                                        </div>
                                        @endforeach
                                        {{ $photos->links() }}
                                    </div>
                                    @else
                                    <center style="padding-top: 115px;">
                                        <i style="font-size: 100px;color: #e9ecef;" class="far fa-image"></i>
                                        <p>
                                            Oh no, your gallery is empty.
                                            <br>Upload new images by clicking Computer icon..
                                    </center>
                                    @endif

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
            const uploadButton = document.querySelector('.browse-btn');
            const fileInfo = document.querySelector('.file-info');
            const realInput = document.getElementById('real-input');
        </script>
        @include('default/footer')