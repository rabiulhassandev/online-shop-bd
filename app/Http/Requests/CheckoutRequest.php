<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * All customers may checkout (guest checkout).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'division_id' => ['required', 'exists:divisions,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'upazila_id' => ['required', 'exists:upazilas,id'],
            'address' => ['required', 'string', 'max:1000'],
            'note' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:cod,bkash,nagad'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'আপনার পূর্ণ নাম দিন।',
            'phone.required' => 'ফোন নম্বর দিন।',
            'division_id.required' => 'বিভাগ নির্বাচন করুন।',
            'district_id.required' => 'জেলা নির্বাচন করুন।',
            'upazila_id.required' => 'উপজেলা নির্বাচন করুন।',
            'address.required' => 'ডেলিভারি ঠিকানা দিন।',
            'payment_method.required' => 'পেমেন্ট পদ্ধতি নির্বাচন করুন।',
        ];
    }
}
