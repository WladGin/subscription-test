<?php

namespace App\Data;

use App\Enums\SubscriptionStatus;

readonly class SubscriptionData
{
    public function __construct(
        public int $plan_id,
        public int $users_count,
        public int $new_billing_period,
        public float $total_price,
        public float $discount,
        public string $date_expired,
        public SubscriptionStatus $status,
    ) {
    }

    public function toArray(): array
    {
        return [
            'plan_id' => $this->plan_id,
            'users_count' => $this->users_count,
            'new_billing_period' => $this->new_billing_period,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'date_expired' => $this->date_expired,
            'status' => $this->status,
        ];
    }
}
