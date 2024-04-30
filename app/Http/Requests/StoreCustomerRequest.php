<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'customer_name' => 'required|regex:/^[a-z0-9\s]+$/i|max:100',
            'email' => 'required|email|unique:customers,email|max:100',
            'phone_number' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'customer_name.regex' => 'Customer Name must contain alpha-numeric characters and spaces'
        ];
    }
}
