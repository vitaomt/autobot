@section('title', 'Calendar') @include('default/header')

<script>
    $(".Calendar a").addClass("activeSidebar");
</script>
<link href="{{ asset('resources/views/default/css/calendar.css') }}" rel="stylesheet" id="bootstrap-css">
<div class="content-main d-flex flex" id="L1">
    <div class="d-flex flex" id="L2">
        <div id="L4">
            @if(empty($accounts))
            <div class="aside-sm middletext">You haven't add any Instagram account yet.
                <br> Click the button below to add your first account.
                <p>
                    <br>
                    <a href="newaccount" class="btn btn-primary specialbutton middle">New account</a>
            </div>
            @endif @if(!empty($accounts))
            <div class="content-main d-flex flex zero" id="content-main">
                <div class="d-flex flex" data-plugin="chat">
                    <div class="col-sm" style="padding-left: 0px;padding-right: 0px">
                        <div class="box">
                            <div class="box-body">
                                <div class="wrapper">
                                    <main>
                                        <div class="toolbar">
                                            <a href="{{ url('calendar?date='.$pre) }}"><div class="toggle__option"><i class="fas fa-chevron-left"></i></div></a>
                                            <div class="current-month" style="text-align: center;"><div style="font-size: 20px;color: black;font-weight: 500;">{{ $date_f }}</div><p>{{ $date_y }}</div>
                                            <a href="{{ url('calendar?date='.$next) }}"><div class="toggle__option"><i class="fas fa-chevron-right"></i></div></a>
                                        </div>
                                        <div class="calendar">
                                            <div class="calendar__header">
                                                <div>mon</div>
                                                <div>tue</div>
                                                <div>wed</div>
                                                <div>thu</div>
                                                <div>fri</div>
                                                <div>sat</div>
                                                <div>sun</div>
                                            </div>
                                            <div class="calendar__week">
                                                @php foreach ($posts as $post) {
                                                $explode = explode(" ", $post->date);
                                                    for ($i=1; $i < $day; $i++) {
                                                        if($i <= 9){
                                                            if ($explode[0]=="2019-".$month."-0" .$i) {
                                                                $a[$i]='<a href="calendar/'.$explode[0].'"><div style="visibility: visible!important;" class="post">Marked</div></a>';
                                                            }
                                                        }else{
                                                            if ($explode[0]=="2019-".$month."-" .$i) {
                                                                $a[$i]='<a href="calendar/'.$explode[0].'"><div style="visibility: visible!important;" class="post">Marked</div></a>';
                                                            }
                                                        }
                                                    }
                                                }
                                                @endphp

                                                @for ($b=1; $b < 36; $b++) 
                                                    @if($b < $day)
                                                        <div class="hover calendar__day day"> {{ $b }}
                                                        @if($b >= date("d"))<div class="left"><a href='{{ url("home?post=".date("Y-m")."-".$b) }}'><i class="fas fa-plus-circle"></i></a></div>@endif
                                                        @if(!empty($a[$b])){!! $a[$b] !!}@endif
                                                        </div>
                                                    @else
                                                        <div class="hover calendar__day day" style="background: #f5f7fb"></div>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </main>
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
@include('default/footer')