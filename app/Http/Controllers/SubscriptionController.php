<?php

namespace Autobot\Http\Controllers;

use Illuminate\Http\Request;
use Autobot\Plan;

class SubscriptionController extends Controller
{
    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));
        
        $request->user()
            ->newSubscription('main', $plan->stripe_plan)
            ->create($request->stripeToken);
        
        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }
}