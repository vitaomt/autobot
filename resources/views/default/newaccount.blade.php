@section('title', 'New Account') @include('default/header')
<script>
    $(".Account a").addClass("activeSidebar");
</script>
<div class="content-main d-flex flex  " id="content-main">
    <div class="d-flex flex" data-plugin="chat">
        <div class="col-sm-4" style="margin-left: -15px">
            @if(isset($_GET['duplicate-account']))
            <div class="alert alert-danger" role="alert">This account has already been added in our database.</div>
            @elseif(isset($_GET['error']))
            <div class="alert alert-danger" role="alert">{{ $_GET['error'] }}</div>
            @endif
            <form method="post" action="{{ url('addaccount') }}">
                @csrf
                <div class="box">
                    <div class="box-body">
                        <div class="alert alert-danger" role="alert">
                            We will send a code to your phone and email address to confirm your account. Please make sure attached in your account has email and phone.
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="username" value="" placeholder="Enter username" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" value="" placeholder="Enter password" required>
                        </div>
                        @if($query->{'ownproxy'} == 1)
                            <div class="form-group">
                                <label>Proxy (Optional)</label>
                                <input type="text" class="form-control" name="proxy" value="" autocomplete="off" placeholder="Proxy for your country">
                            </div>
                            <div class="form-group" style="font-size:12px">
                                <li>Proxy should match following pattern: http://ip:port OR http://username:password@ip:port</li>
                                <li>It's recommended to to use a proxy belongs to the country where you've logged in this acount in Instagram's official app or website.</li>
                            </div>
                        @else
                            <input type="hidden" class="form-control" name="proxy" value="">
                        @endif
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary specialbutton mainbutton">Add account</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('default/footer')