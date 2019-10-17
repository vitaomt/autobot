@section('title', 'System Statistics') @include('default/header')
@if(Auth::user()->role_id != 1)
    @php 
        header("Location: home");
        exit;
    @endphp
@endif
<script>
    $(".Systemstats a").addClass("activeSidebar");
</script>
<div class="content-main" id="content-main">
    <div class="">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-user"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $users }} <span class="text-sm">Users</span></a></h4><small class="text-muted">Registered to system</small></div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-bookmark"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $accounts }} <span class="text-sm">Accounts</span></a></h4><small class="text-muted">Added to system</small></div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-tasks"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $actions }} <span class="text-sm">Actions</span></a></h4><small class="text-muted">Completed automation</small></div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-file"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $photos }} <span class="text-sm">Photos</span></a></h4><small class="text-muted">Uploaded to gallery</small></div>
                </div>
            </div>
        </div>
        
        <div class="box">
            <div id="app">
                {!! $chart->container() !!}
            </div>
            <p><br>
            <div id="app2">
                {!! $chart2->container() !!}
            </div>
            <p><br>
            <div id="app3">
                {!! $chart3->container() !!}
            </div>
            <script src="https://unpkg.com/vue"></script>
            <script>
                var app = new Vue({
                    el: '#app',
                });
            </script>
            <script>
                var app = new Vue({
                    el: '#app2',
                });
            </script>
            <script>
                var app = new Vue({
                    el: '#app3',
                });
            </script>
            <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
            {!! $chart->script() !!}
            {!! $chart2->script() !!}
            {!! $chart3->script() !!}
        </div>
        
    </div>
</div>
@include('default/footer')