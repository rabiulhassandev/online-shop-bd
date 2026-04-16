<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * All customers may submit reviews.
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
            'reviewer_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reviewer_name.required' => 'আপনার নাম দিন।',
            'rating.required' => 'রেটিং দিন।',
            'comment.required' => 'মন্তব্য লিখুন।',
            'comment.min' => 'মন্তব্য কমপক্ষে ১০ অক্ষরের হতে হবে।',
        ];
    }
}
