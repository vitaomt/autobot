<?php

namespace Autobot\Http\Controllers;

use Illuminate\Http\Request;
use Autobot\Plan;
use Config;

class PlanController extends Controller
{
    public function index()
	{
        $plans = Plan::all();
        $cur = Config::get('cashier.currency');
        return view('default.plans', ['cur' => $cur], compact('plans'));
	}

	public function show(Plan $plan, Request $request)
	{
	     return view('default.show', compact('plan'));
	}
}
