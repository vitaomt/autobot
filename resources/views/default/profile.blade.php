@section('title', 'Profile') @include('default/header')
<div class="content-main" id="content-main">
    <div>
        <div class="d-sm-flex">
            <div class="w w-auto-xs light bg bg-auto-sm b-r">
                <div class="py-3">
                    <div class="nav-active-border left b-primary">
                        <ul class="nav flex-column nav-sm">
                            <li class="nav-item">
                                <a class="nav-link active" data-target="#tab-1" data-toggle="tab" href="#">
                                    Account Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col p-0">
                <div class="tab-content pos-rlt">
                    <div class="tab-pane active" id="tab-1">
                        @if(isset($_GET['ok']))
                        <div style="margin: 1.5rem" class="alert alert-success" role="alert">Settings updated successfuly..</div>
                        @endif
                        <form class="p-4 col-md-6" role="form" method="post" action="{{ url('updatesettings') }}">
                            @csrf
                            <div class="form-group">
                                <label>
                                    Register Date
                                </label>
                                <input class="form-control" value="{{ $registerdate }}" disabled type="text" />
                            </div>
                            <div class="form-group">
                                <label>
                                    Email
                                </label>
                                <input class="form-control" value="{{ $email }}" disabled />
                            </div>
                            <div class="form-group">
                                <label>
                                    Name
                                </label>
                                <input class="form-control" value="{{ $name }}" minlength="8" name="name" type="text" required="" />
                            </div>
                            <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                Update
                            </button>
                        </form>
                        <hr>
                        <div class="p-4">
                            <div class="clearfix">
                                @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                <form class="col-md-6 p-0" role="form" method="post" action="{{ route('changePassword') }}">
                                    @csrf
                                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label for="new-password">Current Password</label>
                                        <input id="current-password" type="password" class="form-control" name="current-password" required> @if ($errors->has('current-password'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('current-password') }}</strong>
                                            </span> @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label for="new-password">New Password</label>
                                        <input id="new-password" type="password" class="form-control" name="new-password" required> @if ($errors->has('new-password'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('new-password') }}</strong>
                                            </span> @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="new-password-confirm">Confirm New Password</label>
                                        <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                    </div>

                                    <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                        Change
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('default/footer')