@extends('layout')
@section('content')
    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Current Subscription
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Plan: {{ $currentPlan->title }}</h5>
                        <p class="card-text">
                            Number of users: {{ $user->subscription->users_count }} <br>
                            Billing period: {{ \App\Enums\BillingPeriod::fromValue($user->subscription->billing_period)->description }} <br>
                            Price per user: {{ $currentPlan->price_per_user }} EUR <br>
                            Total price: {{ $user->subscription->total_price }} EUR <br>
                            Discount: {{ $user->subscription->discount }} % <br>
                            Next billing date: {{ $user->subscription->date_expired->format('d-m-Y') }} <br>
                            Status: {{ \App\Enums\SubscriptionStatus::fromValue($user->subscription->status)->description }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Upcoming Subscription Changes
                    </div>
                    <div class="card-body">
                        @empty($nextPlan)
                            <h5 class="card-title">No changes</h5>
                        @endempty

                        @if($nextPlan)
                            <h5 class="card-title">
                                Subscription Changes:
                            </h5>
                            <p class="card-text">
                                Plan: {{$nextPlan->title}} <br>
                                Number of users: {{ $user->subscriptionChange->new_users_count }} <br>
                                Billing period: {{\App\Enums\BillingPeriod::fromValue($user->subscriptionChange->new_billing_period)->description}} <br>
                                Price per user: {{ $nextPlan->price_per_user }} EUR <br>
                                Total price: {{ $user->subscriptionChange->total_price }} EUR <br>
                                Discount: {{ $user->subscriptionChange->discount }} %
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @error('plan_id', 'new_users_count', 'new_billing_period')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Update Subscription
                    </div>
                    <div class="card-body">
                        <form action="{{route('subscriptions.changePlan', $user->subscription)}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="plan" class="form-label">Plan</label>
                                <select class="form-select" name="plan_id" id="plan" onchange="calculateTotal()">
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" data-price="{{ $plan->price_per_user }}" {{ $currentPlan->id === $plan->id ? 'selected' : '' }}>
                                            {{ $plan->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" id="price_per_user">Price per user: {{ $currentPlan->price_per_user }} EUR</label>
                            </div>

                            <div class="mb-3">
                                <label for="user_count" class="form-label">Number of users</label>
                                <input type="number" class="form-control" id="user_count" name="new_users_count" onchange="calculateTotal()" value="{{ $user->subscription->users_count }}" min="1">
                            </div>

                            <!-- Периодичность оплаты -->
                            <div class="mb-3">
                                <label class="form-label">Billing period</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="new_billing_period" id="monthly" value="{{ \App\Enums\BillingPeriod::Monthly }}" onchange="calculateTotal()" checked>
                                        <label class="form-check-label" for="monthly">Monthly</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="new_billing_period" id="yearly" value="{{ \App\Enums\BillingPeriod::Yearly }}" onchange="calculateTotal()">
                                        <label class="form-check-label" for="yearly">Yearly (-20%)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total price</label>
                                <h4 id="total_price">{{ $user->subscription->total_price }} EUR</h4>
                            </div>

                            <button type="submit" class="btn btn-primary" @disabled($nextPlan) @class(['disabled'])>Update subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function calculateTotal() {
            const planSelect = document.getElementById('plan');
            const pricePerUser = planSelect.options[planSelect.selectedIndex].getAttribute('data-price');
            document.getElementById('price_per_user').textContent = 'Price per user: ' + pricePerUser + ' EUR';

            const userCount = document.getElementById('user_count').value;

            const periodicity = document.querySelector('input[name="new_billing_period"]:checked').value;

            let totalPrice = pricePerUser * userCount;

            if (periodicity == {{ \App\Enums\BillingPeriod::Yearly }}) {
                totalPrice = totalPrice * 12 * 0.8; // discount 20%
            }

            document.getElementById('total_price').textContent = totalPrice.toFixed(2) + ' EUR';
        }

        window.onload = calculateTotal;
    </script>
@endsection
