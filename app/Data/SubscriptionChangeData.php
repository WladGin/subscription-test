<?php

namespace App\Data;

readonly class SubscriptionChangeData
{
    public function __construct(
        public int $plan_id,
        public int $user_id,
        public int $new_users_count,
        public int $new_billing_period,
        public float $total_price,
        public float $discount,
    ) {
    }

    public function toArray(): array
    {
        return [
            'plan_id' => $this->plan_id,
            'user_id' => $this->user_id,
            'new_users_count' => $this->new_users_count,
            'new_billing_period' => $this->new_billing_period,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
        ];
    }
}
