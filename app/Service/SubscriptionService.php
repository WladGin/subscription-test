<?php

namespace App\Service;

use App\Data\SubscriptionChangeData;
use App\Data\SubscriptionData;
use App\Models\Subscription;

class SubscriptionService
{
    public function updateSubscription(Subscription $subscription, SubscriptionData $subscriptionData): void
    {
        $subscription->update($subscriptionData->toArray());
    }

    public function createSubscriptionChange(Subscription $subscription, SubscriptionChangeData $subscriptionData): void
    {
        $subscription->subscriptionChange()->create($subscriptionData->toArray());
    }
}
