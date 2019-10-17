@section('title', 'Account Verification') @include('default/header')
<div class="content-main d-flex flex" id="content-main">
    <div class="d-flex flex" data-plugin="chat">
        <div class="col-sm-4" style="margin-top: 15px">
            @if(isset($_GET['error']))
            <div class="alert alert-danger" role="alert">{{ $_GET['error'] }}</div>
            @endif
            <form method="post" action="challange">
                @csrf
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Enter code</label>
                            <input type="text" name="codee" class="specialfont form-control" placeholder="Your verification code" required>
                        </div>
                        <div class="form-group" style="font-size:12px">
                            <li>Verification code sent.. Please check and enter the verification code. If you don't get code, wait 5m and go back.</li>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary specialbutton mainbutton">Confirm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('default/footer')