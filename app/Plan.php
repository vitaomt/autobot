<?php

namespace Autobot;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $table = 'ab_plans';

	protected $fillable = [
        'name',
        'slug',
        'stripe_plan',
        'cost',
        'description'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
