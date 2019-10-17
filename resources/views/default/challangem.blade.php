@section('title', 'Account Verification')
@include('default/header')
<div class="content-main d-flex flex" id="content-main">
    <div class="d-flex flex" data-plugin="chat">
        <div class="col-sm-4" style="margin-top: 15px">
            @if(isset($_GET['error']))
            <div class="alert alert-danger" role="alert">{{ $_GET['error'] }}</div>
            @endif
            <form method="post" action="challangem">
                @csrf
                <div class="box">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Select Method</label>
                            <select class="form-control" required name="choice" id="">
                                <option selected="" disabled="">Select a method..</option>
                                <?php if (isset($data['step_data']['phone_number'])) {
                                    echo '<option value="1">'.$data['step_data']['phone_number'].'</option>';
                            }elseif (isset($data['step_data']['email'])) {
                                    echo '<option value="2">'.$data['step_data']['email'].'</option>';
                            }else{
                              echo '<h3 style="color: red;font-size:12px">You\'ve tried too much to get the code. Please wait 5 minutes and try again.</h3>
                              <p><a href="logout.php" class="btn btn-success specialfont">LOG OUT</a>';
                            } ?>
                            </select>
                        </div>
                        <div class="form-group" style="font-size:12px">
                            <li>Challenge required: Confirm with one of the methods above.</li>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary specialbutton mainbutton">Send my code</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('default/footer')