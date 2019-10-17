@section('title', 'Statistics') @include('default/header')
<script>
    $(".Statistics a").addClass("activeSidebar");
</script>
<div class="content-main" id="content-main">
    @if(empty($check))
    <div class="container text-center padding">
        <div class="padding">You haven't add any Instagram account yet.
            <br> Click the button below to add your first account.
            <p>
                <br>
                <a href="newaccount" class="btn btn-primary specialbutton middle">New account</a>
        </div>
    </div>
    @endif
    @if(!empty($check))
    <div class="">
        <div class="row">
            <div class="col-sm">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-bookmark"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $useraccounts }} <span class="text-sm">Accounts</span></a></h4><small class="text-muted">Added to system</small></div>
                </div>
            </div>

            <div class="col-sm">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-tasks"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $useractions }} <span class="text-sm">Actions</span></a></h4><small class="text-muted">Completed automation</small></div>
                </div>
            </div>

            <div class="col-sm">
                <div class="box list-item" style="padding: 1.75rem .5rem"><span class="avatar w-40 text-center rounded primary"><span class="fa fa-file"></span></span>
                    <div class="list-body">
                        <h4 class="m-0 text-md"><a href="#">{{ $userphotos }} <span class="text-sm">Photos</span></a></h4><small class="text-muted">Uploaded to gallery</small></div>
                </div>
            </div>
        </div>

        <div class="box">
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
            {!! $chart2->script() !!}
            {!! $chart3->script() !!}
        </div>
    </div>
    @endif
</div>
@include('default/footer')