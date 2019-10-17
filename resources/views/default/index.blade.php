@section('title', 'Dashboard') @include('default/header')
<script type="text/javascript">
    //auto expand textarea
    function adjust_textarea(h) {
        h.style.height = "20px";
        h.style.height = (h.scrollHeight) + "px";
    }
</script>
<script>
    $(".Dashboard a").addClass("activeSidebar");
</script>
<div class="content-main" id="content-main">
    <div class="row">
        <div class="col-md-12">
            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active linkone" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                        <div>
                            <i class="fas fa-camera-retro"></i>
                            <div class="type">
                                <div class="blocks">
                                    <span class="name1">Post</span>
                                </div>
                                <div class="phv">
                                    Photo / Video
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link linktwo" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                        <div>
                            <i class="fas fa-images"></i>
                            <div class="type">
                                <div class="blocks">
                                    <span class="name1">Album</span>
                                </div>
                                <div class="phv">
                                    Photo / Video
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link linkthree" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                        <div>
                            <i class="fas fa-arrow-alt-circle-up"></i>
                            <div class="type">
                                <div class="blocks">
                                    <span class="name1">Story</span>
                                </div>
                                <div class="phv">
                                    Photo / Video
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="padding2 box box-sizes">
                                <h6 style="padding-bottom: 10px">
                           Gallery
                           <p class="float-right text-right iconBar">
                              <span class="float-right">
                           <form class="PcForm" method="post" action="{{ url('home-upload') }}" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="user_id" value="{{ $user_id }}">
                           <input type="file" style="width:18px" id="real-input" class="myPc deleteStyle" name="photo[]" multiple="" onchange="javascript:this.form.submit();">
                           <i class="fas fa-desktop"></i>
                           </form>
                           </span> 
                           </p>
                        </h6>
                                <p>
                                    <div class="col-md-9" style="max-width: 100%;">
                                        <div class="row row-xs">
                                            @if(!empty($photos))
                                            <div class="row row-xs">
                                                @foreach ($photos as $photo)
                                                <div class="col-4" class="LinkImage">
                                                    <div class="box p-1">
                                                        <div class="hoveri">
                                                            <a href="{{ url('photodelhome/'.$photo->id) }}"><i style="position: absolute;right: 5px;top: 10px;border: 1px solid #627384;padding: 5px;border-radius: 100px;background: #e5e6e8;z-index: 1000" class="fas fa-trash-alt"></i>
                                                            </a>
                                                            <img class="passImage" style="height: 101px!important;" src="{{ asset('storage/app/photos/home/'.$photo->user_id) }}/{{ $photo->photo }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            {{ $photos->links() }} @endif
                                        </div>
                                        @if(empty($photocheck))
                                        <center style="padding-top: 115px;">
                                            <i style="font-size: 100px;color: #e9ecef;" class="far fa-image"></i>
                                            <p style="color: #C0C0C0">
                                                Oh no, your gallery is empty.
                                                <br>Upload new images by clicking Computer icon..
                                        </center>
                                        @endif
                                    </div>
                                    </p>
                                    </hr>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="padding2 box box-sizes">
                                <h6>
                           Single Post 
                           <p style="font-size: 14px" class="text-right float-right"><i class="fab fa-instagram"></i> <a href="{{ url('newaccount') }}">Add new account</a></p>
                        </h6>
                        <form method="post" action="{{ url('photopost') }}">
                            @csrf
                            @if(isset($_GET['error']))
                            <div class="alert alert-danger" role="alert" style="padding: 0;margin-bottom: 0;margin-top: 10px;margin-left: 5px;margin-right: 5px;text-align: center">{{ $_GET['error'] }}</div>
                            @endif
                            @if(isset($_GET['ok']))
                            <div class="alert alert-success" role="alert" style="padding: 0;margin-bottom: 0;margin-top: 10px;margin-left: 5px;margin-right: 5px;text-align: center">{{ $_GET['ok'] }}</div>
                            @endif
                                <div class="streamline streamline-xs">
                                    <div class="input-group mb-3  custom-selectt">
                                        @if(empty($accountcheck))
                                            <div style="border: 1px solid #754ca41a!important;box-shadow: 0 0 10px 0rem rgba(103, 125, 232, 0.13);padding: 9px;width: 100%;border-radius: 3px;">
                                                No added account
                                            </div>
                                        @endif
                                        <select name="accountselect" class="custom-select custom-select-sm" required>
                                            @if(!empty($accounts)) @foreach($accounts as $showaccounts)
                                                <option value="{{ $showaccounts->username }}">{{ $showaccounts->username }}</option>
                                            @endforeach @endif
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <img id="imgTarget" class="imgTarget" src="">
                                        <input type="hidden" required name="imageurl" id="imgTargetInput" value="">
                                    </div>
                                    <div class="form-style-7">
                                        <ul>
                                            <li>
                                                <label for="caption">Caption</label>
                                                <textarea name="caption" value=""></textarea>
                                            </li>
                                            <li>
                                                <label for="location">Location</label>
                                                <input type="text" name="location" value="" maxlength="100">
                                                <span>Leave empty to post without a location</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <p>
                                    <!-- <div class="streamline-xs">
                                        <div class="input-group mb-3  custom-selectt">
                                            <select class="custom-select custom-select-sm">
                                                <option selected="" style="border-color: #754ca461;box-shadow: 0 0 10px 0rem rgba(103, 125, 232, 0.27);">
                                                    Photo Filter
                                                </option>
                                                <option>Normal</option>
                                                <option>Black & White</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="input-group mb-3">
                                        <div class="custom-checkbox">
                                            <label class='ui-check'>
                                                <input type='checkbox' name='postnow' class="input_control" value='1'><i></i> <text style="font-size: .8rem;">Post right now</text>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        @if(isset($_GET['post']))
                                        <input type='datetime-local' class="datebox" name='date' value="{{ $_GET['post'] }}T{{ date('H:i') }}" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" id="date" style="margin-bottom: 15px;" required="">
                                        @else
                                        <input type='datetime-local' class="datebox" name='date' value="{{ date('Y-m-d') }}T{{ date('H:i') }}" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" id="date" style="margin-bottom: 15px;" required="">
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-checkbox">
                                            <label class='ui-check'>
                                                <input type='checkbox' name='deletephoto' value='1'><i></i> <text style="font-size: .8rem;">Remove media from server after posting</text>
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary specialbutton" type="submit">
                                        POST
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <section class="section">
                                <div class="post-preview" data-type="timeline">
                                    <div class="preview-header">
                                        <img src="{{ asset('resources/views/default/images/instagram-logo.png') }}" alt="Instagram">
                                    </div>
                                    <div class="preview-account clearfix">
                                        <span class="circle"></span>
                                        <span class="lines">
                                        <span class="line-placeholder" style="width: 47.76%"></span>
                                        <span class="line-placeholder" style="width: 29.85%"></span>
                                        </span>
                                    </div>
                                    <div class="preview-media--timeline">
                                        <div class="placeholder"><img id="imgTargetview2" src="" style="width: 100%;height: auto"></div>
                                    </div>
                                    <div class="story-placeholder"></div>
                                    <div class="preview-media--album">
                                    </div>
                                    <div class="preview-caption-wrapper">
                                        <div class="preview-caption-placeholder" style="">
                                            <span class="line-placeholder"></span>
                                            <span class="line-placeholder" style="width: 61.19%"></span>
                                        </div>
                                        <div class="preview-caption" style=""></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="padding2 box box-sizes">
                                <h6 style="padding-bottom: 10px">
                           Gallery
                           <p class="float-right text-right iconBar">
                              <span class="float-right">
                           <form class="PcForm" method="post" action="{{ url('home-upload') }}" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="user_id" value="{{ $user_id }}">
                           <input type="file" style="width:18px" id="real-input" class="myPc deleteStyle" name="photo[]" multiple="" onchange="javascript:this.form.submit();">
                           <i class="fas fa-desktop"></i>
                           </form>
                           </span> 
                           </p>
                        </h6>
                                <p>
                                    <div class="col-md-9" style="max-width: 100%;">
                                        <div class="row row-xs">
                                            @if(!empty($photos))
                                            <div class="row row-xs">
                                                @foreach ($photos as $photo)
                                                <div class="col-4" class="LinkImage">
                                                    <div class="box p-1">
                                                        <div class="hoveri">
                                                            <a href="{{ url('photodelhome/'.$photo->id) }}"><i style="position: absolute;right: 5px;top: 10px;border: 1px solid #627384;padding: 5px;border-radius: 100px;background: #e5e6e8;z-index: 1000" class="fas fa-trash-alt"></i>
                                                            </a>
                                                            <img class="passImage passImageGallery" id="<?php echo str_replace(".jpg", "", $photo->photo ) ?>" style="height: 101px!important;" src="{{ asset('storage/app/photos/home/'.$photo->user_id) }}/{{ $photo->photo }}" />

                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            {{ $photos->links() }} @endif
                                        </div>
                                        @if(empty($photocheck))
                                        <center style="padding-top: 115px;">
                                            <i style="font-size: 100px;color: #e9ecef;" class="far fa-image"></i>
                                            <p style="color: #C0C0C0">
                                                Oh no, your gallery is empty.
                                                <br>Upload new images by clicking Computer icon..
                                        </center>
                                        @endif
                                    </div>
                                    </p>
                                    </hr>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="padding2 box box-sizes">
                                <h6>
                           Album Post 
                           <p style="font-size: 14px" class="text-right float-right"><i class="fab fa-instagram"></i> <a href="{{ url('newaccount') }}">Add new account</a></p>
                        </h6>
                        <form method="post" action="{{ url('albumpost') }}">
                            @csrf
                            @if(isset($_GET['error']))
                            <div class="alert alert-danger" role="alert" style="padding: 0;margin-bottom: 0;margin-top: 10px;margin-left: 5px;margin-right: 5px;text-align: center">{{ $_GET['error'] }}</div>
                            @endif
                            @if(isset($_GET['ok']))
                            <div class="alert alert-success" role="alert" style="padding: 0;margin-bottom: 0;margin-top: 10px;margin-left: 5px;margin-right: 5px;text-align: center">{{ $_GET['ok'] }}</div>
                            @endif
                                <div class="streamline streamline-xs">
                                    <div class="input-group mb-3  custom-selectt">
                                        @if(empty($accountcheck))
                                            <div style="border: 1px solid #754ca41a!important;box-shadow: 0 0 10px 0rem rgba(103, 125, 232, 0.13);padding: 9px;width: 100%;border-radius: 3px;">
                                                No added account
                                            </div>
                                        @endif
                                        <select name="accountselect" class="custom-select custom-select-sm" required>
                                            @if(!empty($accounts)) @foreach($accounts as $showaccounts)
                                                <option value="{{ $showaccounts->username }}">{{ $showaccounts->username }}</option>
                                            @endforeach @endif
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div id="albumImages">
                                            <img id="imgTargetAlbum" class="imgTarget" src="">
                                        </div>
                                    </div>
                                    <div class="form-style-7">
                                        <ul>
                                            <li>
                                                <label for="caption">Caption</label>
                                                <textarea name="caption" value=""></textarea>
                                            </li>
                                            <li>
                                                <label for="location">Location</label>
                                                <input type="text" name="location" value="" maxlength="100">
                                                <span>Leave empty to post without a location</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <p>
                                    <!-- <div class="streamline-xs">
                                        <div class="input-group mb-3  custom-selectt">
                                            <select class="custom-select custom-select-sm">
                                                <option selected="" style="border-color: #754ca461;box-shadow: 0 0 10px 0rem rgba(103, 125, 232, 0.27);">
                                                    Photo Filter
                                                </option>
                                                <option>Normal</option>
                                                <option>Black & White</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="input-group mb-3">
                                        <div class="custom-checkbox">
                                            <label class='ui-check'>
                                                <input type='checkbox' name='postnow' class="input_control" value='1'><i></i> <text style="font-size: .8rem;">Post right now</text>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        @if(isset($_GET['post']))
                                        <input type='datetime-local' class="datebox" name='date' value="{{ $_GET['post'] }}T{{ date('H:i') }}" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" id="date" style="margin-bottom: 15px;" required="">
                                        @else
                                        <input type='datetime-local' class="datebox" name='date' value="{{ date('Y-m-d') }}T{{ date('H:i') }}" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" id="date" style="margin-bottom: 15px;" required="">
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-checkbox">
                                            <label class='ui-check'>
                                                <input type='checkbox' name='deletephoto' value='1'><i></i> <text style="font-size: .8rem;">Remove media from server after posting</text>
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary specialbutton" type="submit">
                                        POST
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <section class="section">
                                <div class="post-preview" data-type="timeline">
                                    <div class="preview-header">
                                        <img src="{{ asset('resources/views/default/images/instagram-logo.png') }}" alt="Instagram">
                                    </div>
                                    <div class="preview-account clearfix">
                                        <span class="circle"></span>
                                        <span class="lines">
                                        <span class="line-placeholder" style="width: 47.76%"></span>
                                        <span class="line-placeholder" style="width: 29.85%"></span>
                                        </span>
                                    </div>
                                    <div class="preview-media--timeline">
                                        <div class="placeholder"><img id="imgTargetview22" src="" style="width: 100%;height: auto"></div>
                                    </div>
                                    <div class="story-placeholder"></div>
                                    <div class="preview-media--album">
                                    </div>
                                    <div class="preview-caption-wrapper">
                                        <div class="preview-caption-placeholder" style="">
                                            <span class="line-placeholder"></span>
                                            <span class="line-placeholder" style="width: 61.19%"></span>
                                        </div>
                                        <div class="preview-caption" style=""></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="padding2 box box-sizes">
                                <h6 style="padding-bottom: 10px">
                           Gallery
                           <p class="float-right text-right iconBar">
                              <span class="float-right">
                           <form class="PcForm" method="post" action="{{ url('home-upload') }}" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="user_id" value="{{ $user_id }}">
                           <input type="file" style="width:18px" id="real-input" class="myPc deleteStyle" name="photo[]" multiple="" onchange="javascript:this.form.submit();">
                           <i class="fas fa-desktop"></i>
                           </form>
                           </span> 
                           </p>
                        </h6>
                                <p>
                                    <div class="col-md-9" style="max-width: 100%;">
                                        <div class="row row-xs">
                                            @if(!empty($photos))
                                            <div class="row row-xs">
                                                @foreach ($photos as $photo)
                                                <div class="col-4" class="LinkImage">
                                                    <div class="box p-1">
                                                        <div class="hoveri">
                                                            <a href="{{ url('photodelhome/'.$photo->id) }}"><i style="position: absolute;right: 5px;top: 10px;border: 1px solid #627384;padding: 5px;border-radius: 100px;background: #e5e6e8;z-index: 1000" class="fas fa-trash-alt"></i>
                                                            </a>
                                                            <img class="passImageStory" style="height: 101px!important;width: 100%!important;" src="{{ asset('storage/app/photos/home/'.$photo->user_id) }}/{{ $photo->photo }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            {{ $photos->links() }} @endif
                                        </div>
                                        @if(empty($photocheck))
                                        <center style="padding-top: 115px;">
                                            <i style="font-size: 100px;color: #e9ecef;" class="far fa-image"></i>
                                            <p style="color: #C0C0C0">
                                                Oh no, your gallery is empty.
                                                <br>Upload new images by clicking Computer icon..
                                        </center>
                                        @endif
                                    </div>
                                    </p>
                                    </hr>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="padding2 box box-sizes">
                                <h6>
                           Story Post 
                           <p style="font-size: 14px" class="text-right float-right"><i class="fab fa-instagram"></i> <a href="{{ url('newaccount') }}">Add new account</a></p>
                        </h6>
                        <form method="post" action="{{ url('storypost') }}">
                            @csrf
                            @if(isset($_GET['error']))
                            <div class="alert alert-danger" role="alert" style="padding: 0;margin-bottom: 0;margin-top: 10px;margin-left: 5px;margin-right: 5px;text-align: center">{{ $_GET['error'] }}</div>
                            @endif
                            @if(isset($_GET['ok']))
                            <div class="alert alert-success" role="alert" style="padding: 0;margin-bottom: 0;margin-top: 10px;margin-left: 5px;margin-right: 5px;text-align: center">{{ $_GET['ok'] }}</div>
                            @endif
                                <div class="streamline streamline-xs">
                                    <div class="input-group mb-3  custom-selectt">
                                        @if(empty($accountcheck))
                                            <div style="border: 1px solid #754ca41a!important;box-shadow: 0 0 10px 0rem rgba(103, 125, 232, 0.13);padding: 9px;width: 100%;border-radius: 3px;">
                                                No added account
                                            </div>
                                        @endif
                                        <select name="accountselect" class="custom-select custom-select-sm" required>
                                            @if(!empty($accounts)) @foreach($accounts as $showaccounts)
                                                <option value="{{ $showaccounts->username }}">{{ $showaccounts->username }}</option>
                                            @endforeach @endif
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <img id="imgTargetStory" class="imgTarget" src="">
                                        <input type="hidden" required name="imageurl" id="imgTargetInputStory" value="">
                                    </div>
                                    <div class="form-style-7">
                                        <ul>
                                            <li>
                                                <label for="caption">Caption</label>
                                                <textarea name="caption" style="background: white" disabled value=""></textarea>
                                            </li>
                                            <li>
                                                <label for="location">Location</label>
                                                <input type="text" name="location" style="background: white" disabled value="" maxlength="100">
                                                <span>Leave empty to post without a location</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <p>
                                    <!-- <div class="streamline-xs">
                                        <div class="input-group mb-3  custom-selectt">
                                            <select class="custom-select custom-select-sm">
                                                <option selected="" style="border-color: #754ca461;box-shadow: 0 0 10px 0rem rgba(103, 125, 232, 0.27);">
                                                    Photo Filter
                                                </option>
                                                <option>Normal</option>
                                                <option>Black & White</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="input-group mb-3">
                                        <div class="custom-checkbox">
                                            <label class='ui-check'>
                                                <input type='checkbox' name='postnow' class="input_control" value='1'><i></i> <text style="font-size: .8rem;">Post right now</text>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        @if(isset($_GET['post']))
                                        <input type='datetime-local' class="datebox" name='date' value="{{ $_GET['post'] }}T{{ date('H:i') }}" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" id="date" style="margin-bottom: 15px;" required="">
                                        @else
                                        <input type='datetime-local' class="datebox" name='date' value="{{ date('Y-m-d') }}T{{ date('H:i') }}" min="{{ date('Y-m-d') }}T{{ date('H:i') }}" id="date" style="margin-bottom: 15px;" required="">
                                        @endif
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-checkbox">
                                            <label class='ui-check'>
                                                <input type='checkbox' name='deletephoto' value='1'><i></i> <text style="font-size: .8rem;">Remove media from server after posting</text>
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary specialbutton" type="submit">
                                        POST
                                    </button>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <section class="section">
                                <div class="post-preview" data-type="timeline">
                                    <div class="preview-header">
                                        <img src="{{ asset('resources/views/default/images/instagram-logo.png') }}" alt="Instagram">
                                    </div>
                                    <div class="preview-account clearfix">
                                        <span class="circle"></span>
                                        <span class="lines">
                                        <span class="line-placeholder" style="width: 47.76%"></span>
                                        <span class="line-placeholder" style="width: 29.85%"></span>
                                        </span>
                                    </div>
                                    <div class="preview-media--timeline">
                                        <div class="placeholder"><img id="imgTargetviewStory" src="" style="width: 100%;height: auto"></div>
                                    </div>
                                    <div class="story-placeholder"></div>
                                    <div class="preview-media--album">
                                    </div>
                                    <div class="preview-caption-wrapper">
                                        <div class="preview-caption-placeholder" style="">
                                            <span class="line-placeholder"></span>
                                            <span class="line-placeholder" style="width: 61.19%"></span>
                                        </div>
                                        <div class="preview-caption" style=""></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@if(isset($_GET['post']))
<script>
    $(document).ready(function(){
        $('.input_control').change(function () {
            $(".datebox").prop('hidden', this.checked);
            $(".datebox").prop('disabled', this.checked);
        });
        $('.input_control').prop('unchecked', true);
        $('.input_control').trigger('change');
    });
</script>
@else
<script>
    $(document).ready(function(){
        $('.input_control').change(function () {
            $(".datebox").prop('hidden', this.checked);
            $(".datebox").prop('disabled', this.checked);
        });
        $('.input_control').prop('checked', true);
        $('.input_control').trigger('change');
    });
</script>
@endif
<script>
    var x, i, j, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-selectt");
    for (i = 0; i < x.length; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < selElmnt.length; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;
                for (i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
</script>
@include('default/footer')