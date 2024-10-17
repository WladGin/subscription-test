<?php

namespace App\Jobs;

use App\Enums\BillingPeriod;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RenewNextSubscriptionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $expiredSubscriptions = Subscription::query()
            ->where('date_expired', '<', now())
            ->with('subscriptionChange')
            ->get()
            ->map(function (Subscription $subscription) {
                if (empty($subscription->subscriptionChange)) {
                    return $subscription->id;
                }

                $effectiveDate = $subscription->subscriptionChange->new_billing_period->is(BillingPeriod::Yearly()) ? now()->addYear() : now()->addMonth();

                $subscription->update([
                    'plan_id' => $subscription->subscriptionChange->plan_id,
                    'users_count' => $subscription->subscriptionChange->new_users_count,
                    'total_price' => $subscription->subscriptionChange->total_price,
                    'discount' => $subscription->subscriptionChange->discount,
                    'billing_period' => $subscription->subscriptionChange->new_billing_period,
                    'date_expired' => $effectiveDate,
                    'status' => SubscriptionStatus::Active,
                ]);

                $subscription->subscriptionChange->delete();

                return null;
            })
            ->filter(fn ($item) => $item !== null);

        if ($expiredSubscriptions->isNotEmpty()) {
            Subscription::query()
                ->whereIn('id', $expiredSubscriptions)
                ->update(['status' => SubscriptionStatus::Expired]);
        }
    }
}
