@section('title', 'Plans') @include('default/header')
<div class="app-content box-shadow-0" id="content" role="main">
    <div class="content-main" id="content-main">
        <div class="padding">
            <div class="px-5">
                <div class="pricing-header px-3 py-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4">Plans</h1>
                    <p class="lead">Becoming a premium member is always great!<br>Beat your opponents on social media, choosing the plan that suits you best!</p>
                </div>
                <div class="container">
                    
                    <div class="row no-gutters">
                        <div class="card-deck mb-3 text-center">
                            @foreach($plans as $plan)
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header" style="background: linear-gradient(57deg, #667eea 0%, #764ba2 100%);color: white">
                                    <h4 class="my-0 font-weight-normal">{{ $plan->name }}</h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title" style="font-size: 2rem">{{ str_replace("usd", "$", $cur) }}{{ number_format($plan->cost, 2) }} <small class="text-muted" style="font-size: 1rem">/ mo</small></h1>
                                    <ul class="list-unstyled mt-3 mb-4">
                                        <li>10 users included</li>
                                        <li>2 GB of storage</li>
                                        <li>Email support</li>
                                        <li>Help center access</li>
                                    </ul>
                                    <a href="{{ route('default.show', $plan->slug) }}" class="btn btn-primary specialbutton middle">Choose!</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('default/footer')