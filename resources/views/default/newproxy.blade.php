@section('title', 'New Proxy') @include('default/header')
<script>
    $(".Proxies a").addClass("activeSidebar");
</script>
<div class="content-main d-flex flex  " id="content-main">
    <div class="d-flex flex" data-plugin="chat">
        <div class="col-sm-4" style="margin-left: -15px">
            @if(isset($_GET['error']))
            <div class="alert alert-danger" role="alert">{{ $_GET['error'] }}</div>
            @endif
            <form method="post" action="{{ url('newproxy') }}">
                @csrf
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Proxy</label>
                            <input type="text" class="form-control" name="proxy" autocomplete="off" placeholder="Proxy for your country" required="">
                        </div>                        
                        <div class="form-group" style="font-size:12px">
                            <li>Proxy should match following pattern: http://ip:port OR http://username:password@ip:port</li>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary specialbutton mainbutton">Add proxy</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('default/footer')