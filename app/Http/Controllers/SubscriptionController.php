<?php

namespace App\Http\Controllers;

use App\Data\SubscriptionChangeData;
use App\Data\SubscriptionData;
use App\Enums\BillingPeriod;
use App\Enums\SubscriptionStatus;
use App\Http\Requests\ChangePlanRequest;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Service\SubscriptionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $plans = Plan::all();
        $user = User::query()->with(['subscription', 'subscriptionChange'])->first();
        $currentPlan = $plans->firstWhere('id', $user->subscription->plan_id);
        $nextPlan = $plans->firstWhere('id', $user->subscriptionChange?->plan_id);

        return view('subscription.index', compact('plans', 'user', 'currentPlan', 'nextPlan'));
    }

    public function changePlan(Subscription $subscription, ChangePlanRequest $request, SubscriptionService $subscriptionService): RedirectResponse
    {
        if ($subscription->subscriptionChange !== null) {
            return redirect()->back()->with('error', 'You already have a pending plan change request.');
        }

        $plan = Plan::query()->find($request->plan_id);

        $totalPrice = $request->new_users_count * $plan->price_per_user;
        $effectiveDate = now()->addMonth();
        $discount = 0;

        if (BillingPeriod::Yearly()->is($request->new_billing_period)) {
            $totalPrice *= 12 * 0.8;
            $discount = 20;
            $effectiveDate = now()->addYear();
        }

        if ($subscription->status->is(SubscriptionStatus::Expired)) {
            $subscriptionData = new SubscriptionData(
                plan_id: $request->plan_id,
                users_count: $request->new_users_count,
                new_billing_period: $request->new_billing_period,
                total_price: $totalPrice,
                discount: $discount,
                date_expired: $effectiveDate,
                status: SubscriptionStatus::Active()
            );
            $subscriptionService->updateSubscription($subscription, $subscriptionData);
        } else {
            $subscriptionChangeData = new SubscriptionChangeData(
                plan_id: $request->plan_id,
                user_id: $subscription->user_id,
                new_users_count: $request->new_users_count,
                new_billing_period: $request->new_billing_period,
                total_price: $totalPrice,
                discount: $discount,
            );

            $subscriptionService->createSubscriptionChange($subscription, $subscriptionChangeData);
        }

        return redirect()
            ->back()
            ->with('success', 'Subscription plan updated successfully.');
    }
}
