<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function plan() 
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }
}
