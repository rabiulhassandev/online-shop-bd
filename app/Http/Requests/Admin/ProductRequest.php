<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProductRequest extends FormRequest
{
    /**
     * Only admins may create/update products.
     */
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * @return array<string, list<string|File>>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'.($productId ? ",{$productId}" : '')],
            'description' => ['nullable', 'string'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'images.*' => ['nullable', 'image', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'discount_start_at' => ['nullable', 'date'],
            'discount_end_at' => ['nullable', 'date', 'after:discount_start_at'],
            'sizes' => ['nullable', 'array'],
            'sizes.*.size' => ['required', 'in:S,M,L,XL,XXL,3XL,4XL'],
            'sizes.*.stock' => ['required', 'integer', 'min:0'],
            'colors' => ['nullable', 'array'],
            'colors.*' => ['required', 'string', 'max:50'],
            'is_featured' => ['nullable', 'boolean'],
            'is_new_arrival' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
