<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Enums\PaymentStatus;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|decimal:2',
            'payment_date' => 'date_format:Y-m-d H:i:s|after_or_equal:now',
            'status' => 'payment_status'
        ];
    }
}
