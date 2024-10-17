<?php

namespace App\Models;

use App\Enums\BillingPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionChange extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'subscription_id',
        'user_id',
        'plan_id',
        'new_users_count',
        'new_billing_period',
        'total_price',
        'discount',
    ];

    protected $casts = [
        'new_billing_period' => BillingPeriod::class,
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
