<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'stripe_subscription_id', 'stripe_customer_id',
        'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    public function isExpired()
    {
        return $this->end_date->isPast();
    }

    public function daysRemaining()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function renew()
    {
        $this->update([
            'end_date' => $this->end_date->addMonths($this->plan->duracion),
            'status' => 'active'
        ]);
    }

    public function cancel()
    {
        $this->update(['status' => 'canceled']);
    }
}