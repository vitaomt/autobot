@section('title', 'Calendar') @include('default/header')
<script>
    $(".Calendar a").addClass("activeSidebar");
</script>
<div class="content-main" id="content-main">
    <div class="">
        <div class="row">
            @php
                foreach($posts as $post){
                $explode = explode(" ", $post->date);
                    if($explode[0] == $date) {
                        echo '<div class="col-sm-3 padding">
                                <div class="card" style="width: 225px;">
                                    <div class="card-footer">
                                        <small class="text-muted" style="text-transform: capitalize;">'.$post->type.'</small>
                                        <div class="dropdown">
                                          <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: absolute;right: 0px;top: -20px;color: #848484">&nbsp; <i class="fas fa-ellipsis-v"></i>&nbsp; </a>

                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="delete/'.$post->username.'/'.$post->id.'">Delete</a>
                                          </div>
                                        </div>
                                    </div>
                                    <center><img class="card-img-top img-fluid" style="width: 188px;height: 188px;margin-top: 15px" src="'.$post->imageurl.'"></center>
                                    <div class="card-body">
                                        <h6 class="card-title">'.$post->location.'</h6>
                                        <p class="card-text">'.$post->caption.'</p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted"><i class="fab fa-instagram"></i>&nbsp; '.$post->username.'</small>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted"><i class="far fa-clock"></i>&nbsp; Schedule Post</small>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted"><i class="far fa-calendar-check"></i>&nbsp; '.$post->date.'</small>
                                    </div>
                                </div>
                            </div>';
                    }
                }
            @endphp
        </div>
    </div>
</div>


@include('default/footer')