@section('title', 'Configuration') @include('default/header')
@if(Auth::user()->role_id != 1)
    @php 
        header("Location: home");
        exit;
    @endphp
@endif
<script>
    $(".Settings a").addClass("activeSidebar");
</script>
<div class="content-main" id="content-main">
    <div>
        <div class="d-sm-flex">
            <div class="w w-auto-xs light bg bg-auto-sm b-r">
                <div class="py-3">
                    <div class="nav-active-border left b-primary">
                        <ul class="nav flex-column nav-sm">
                            <li class="nav-item">
                                <div style="font-size: 15px;color:black;margin-left: 5px;margin-bottom: 15px;">General Settings</div>
                                <a class="nav-link active" data-target="#tab-1" data-toggle="tab" href="#">
                                    System Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-target="#tab-2" data-toggle="tab" href="#">
                                    Proxy Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-target="#tab-4" data-toggle="tab" href="#">
                                    Maintenance Mode
                                </a>
                                <hr>
                            </li>
                            <li class="nav-item">
                                <div style="font-size: 15px;color:black;margin-left: 5px;margin-bottom: 15px;">Security</div>
                                <a class="nav-link" data-target="#tab-5" data-toggle="tab" href="#">
                                    ReCaptcha
                                </a>
                                <hr>
                            </li>
                            <li class="nav-item">
                                <div style="font-size: 15px;color:black;margin-left: 5px;margin-bottom: 15px">Integrations</div>
                                <a class="nav-link" data-target="#tab-6" data-toggle="tab" href="#">
                                    Google Analytics
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col p-3">
                <div class="tab-content pos-rlt">
                    <div class="tab-pane active" id="tab-1">
                        <form class="p-4 col-md-6" method="POST" action="{{ url('systemsettingsu') }}">
                            @csrf
                            <div class="form-group">
                                <label>
                                    Site Name
                                </label>
                                <input class="form-control form-8" value="{{ $ssdata->{'name'} }}" name="name" type="text"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    Site Description
                                </label>
                                <textarea class="form-control form-8" placeholder="Recommended length of the description is 150-160 characters" name="description" maxlength="255" rows="5" />{{ $ssdata->{'description'} }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>
                                    Site Keywords
                                </label>
                                <textarea class="form-control form-8" name="keywords" maxlength="255" rows="5" />{{ $ssdata->{'keywords'} }}</textarea>
                            </div>
                            <!-- <div class="checkbox">
                                <label class="ui-check">
                                    <input type="checkbox">
                                        <i class="dark-white"></i> &nbsp;Email Verification
                                    </input>
                                </label>
                            </div> --><br>
                            <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                Update
                            </button>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-2">
                        <form class="p-4 col-md-6" method="POST" action="{{ url('proxysettingsu') }}">
                            @csrf
                            <div class="checkbox">
                                <label class="ui-check">
                                    {!! str_replace("value='".$psdata->{'sysproxies'}."'","value='".$psdata->{'sysproxies'}."' checked","
                                    <input type='checkbox' name='sysproxies' value='1'>
                                        <i class='dark-white'></i> &nbsp;Use System Proxies
                                    </input>") !!}
                                </label>
                                <li>If you enable this option, system will try use most appropriate proxy from your proxy list while new acount is being added.</li>
                            </div><br>
                            <div class="checkbox">
                                <label class="ui-check">
                                    {!! str_replace("value='".$psdata->{'ownproxy'}."'","value='".$psdata->{'ownproxy'}."' checked","
                                    <input type='checkbox' name='ownproxy' value='1'>
                                        <i class='dark-white'></i> &nbsp;Users can add their own proxy address
                                    </input>") !!}
                                </label>
                            </div><br>
                            <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                Update
                            </button>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-4">
                        <form class="p-4 col-md-6" method="POST" action="{{ url('down') }}">
                            @csrf
                            <li>When your application is in maintenance mode, a custom view will be displayed for all requests into your application. This makes it easy to "disable" your application while it is updating or when you are performing maintenance.</li><br>
                            <div class="form-group">
                                <label>
                                    Message
                                </label>
                                <input class="form-control form-8" value="" name="message" maxlength="100" type="text"/>
                            </div>
                            <li>You may also provide message. The message value may be used to display a custom message.</li><br>
                            <li><strong><u>To disable maintenance mode, open /up url. (yourdomain.com/up)</u></strong></li><br>
                            <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                Update
                            </button>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-5">
                        <form class="p-4 col-md-6" method="POST" action="{{ url('recaptchau') }}">
                            @csrf
                            <div class="form-group">
                                <label>
                                    Site Key
                                </label>
                                <input class="form-control form-8" value="{{ $rcdata->{'sitekey'} }}" name="sitekey" type="text"/>
                            </div>
                            <div class="form-group">
                                <label>
                                    Secret
                                </label>
                                <input class="form-control form-8" value="{{ $rcdata->{'secret'} }}" name="secret" type="text"/><br>
                                <li>Valid site and secret keys are required.</li>
                            </div>
                            <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                Update
                            </button>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-6">
                        <form class="p-4 col-md-6" method="POST" action="{{ url('analyticsu') }}">
                            @csrf
                            <div class="form-group">
                                <label>
                                    Google Analytics Property ID
                                </label>
                                <input class="form-control form-8" name="analyticsid" value="{{ $andata->{'analyticsid'} }}" type="text"/>
                            </div>
                            <li>Leave this field empty if you don't want to enable Google Analytics</li><br>
                            <button class="btn btn-primary specialbutton specialsmall mainbutton" type="submit">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('default/footer')