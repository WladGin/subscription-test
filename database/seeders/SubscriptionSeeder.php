<?php

namespace Database\Seeders;

use App\Enums\BillingPeriod;
use App\Enums\SubscriptionStatus;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $litePlan = Plan::query()
            ->where('title', 'Lite')
            ->first();

        $user = User::query()->find(1);

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $litePlan->id,
            'users_count' => 7,
            'total_price' => 28.00,
            'discount' => 0,
            'status' => SubscriptionStatus::Active,
            'billing_period' => BillingPeriod::Monthly,
            'date_expired' => Carbon::now()->addMonth(),
        ]);
    }
}
