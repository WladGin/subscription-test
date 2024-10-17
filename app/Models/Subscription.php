<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'users_count',
        'total_price',
        'status',
        'discount',
        'billing_period',
        'date_expired',
    ];

    protected $casts = [
        'date_expired' => 'date',
        'status' => SubscriptionStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscriptionChange(): HasOne
    {
        return $this->hasOne(SubscriptionChange::class);
    }
}
