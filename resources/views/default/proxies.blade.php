@section('title', 'Proxies') @include('default/header')
@if(Auth::user()->role_id != 1)
    @php 
        header("Location: home");
        exit;
    @endphp
@endif
<script>
    $(".Proxies a").addClass("activeSidebar");
</script>
<div class="content-main d-flex flex" id="L1">
    <div class="d-flex flex" id="L2">
        <div class="" id="L3">
            <div class="fade aside">
                <div class="d-flex flex-column w-xl b-r white modal-dialog">
                    <div class="scrollable hover">
                        <div class="list inset">
                            <div class="list-item">
                                <a href="{{ url('newproxy') }}" class="btn btn-primary specialbutton mainbutton">Add new proxy</a>
                            </div>
                            <div class="p-2 px-3 text-muted text-sm">
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                Select a proxy
                            </div>
                            @if(!empty($proxies)) @foreach($proxies as $showproxies)
                            <div class="list-item"><a href="{{ url('proxies/'.$showproxies->id) }}"><span class="avatar w-32" style="background-color: black;color: white;line-height: 0"><strong>P</strong></span>
                                <div class="list-body" style="overflow: hidden"><div class="item-title _500">{{ $showproxies->proxy }}</div>
                                <div class="item-except text-sm text-muted h-1x" style="font-weight:400"></div></a>
                                    <div class="item-tag tag hide"></div>
                                </div>
                            </div>
                            @endforeach @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="L4">
            @if(empty($proxies))
            <div class="aside-sm middletext">You haven't add any Proxy yet.
                <br> Click the button below to add your first proxy.
                <p>
                    <br>
                    <a href="{{ url('newproxy') }}" class="btn btn-primary specialbutton middle">New Proxy</a>
            </div>
            @endif
            @if(!empty($proxies)) @if(empty($editproxy))
            <div class="aside-sm middletext">Please select a proxy from left side list.</div>
            @else
            <div class="content-main d-flex flex zero" id="content-main">
                <div class="d-flex flex" data-plugin="chat">
                    <div class="col-sm">
                        <form method="POST" action="{{ url('updateproxies') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="box">
                                <label class="form-control myLabel">Edit proxy
                                    <div class="text-right" style="margin-top: -19px"><button style="background: transparent;border:0px;padding: 0px" type="button" data-toggle="modal" data-target="#m-a-a" data-toggle-class="fade-down" data-toggle-class-target="#animate">Delete this proxy</button></div>
                                </label>
                                <div class="box-body">

                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="form-style-7">
                                                <ul>
                                                    <li>
                                                        <label for="caption">Proxy</label>
                                                        <input type="text" name="proxy" value="{{ $proxy }}" required="">
                                                        <span>Proxy should match following pattern: http://ip:port OR http://username:password@ip:port</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><p><br>

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary specialbutton mainbutton">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="m-a-a" class="modal fade" data-backdrop="true">
                            <div class="modal-dialog animate" id="animate">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete this proxy!</h5></div>
                                    <div class="modal-body text-center p-lg">
                                        <p>Are you sure to delete this proxy?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark-white p-x-md modbtn" data-dismiss="modal">No</button>
                                        <a href="{{ url('deleteproxy/'.$id) }}" class="btn danger p-x-md modbtn">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif @endif
    </div>

</div>
@include('default/footer')