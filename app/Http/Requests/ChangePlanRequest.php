<?php

namespace App\Http\Requests;

use App\Enums\BillingPeriod;
use App\Models\Plan;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePlanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'plan_id' => ['required', 'integer', Rule::exists(Plan::class, 'id')],
            'new_users_count' => ['required', 'integer', 'min:1'],
            'new_billing_period' => ['required', 'integer', new EnumValue(BillingPeriod::class)],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Convert the new_billing_period to an integer because it is a string when it comes from the request
        $this->merge([
            'new_billing_period' => !is_null($this->new_billing_period) ? (int)$this->new_billing_period : null,
        ]);
    }
}
