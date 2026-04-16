<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscountController extends Controller
{
    /**
     * Show the discount management page.
     */
    public function index(): View
    {
        $products = Product::active()
            ->select(['id', 'name', 'price', 'discounted_price', 'discount_start_at', 'discount_end_at'])
            ->latest()
            ->paginate(20);

        return view('admin.discounts.index', compact('products'));
    }

    /**
     * Update discount on a single product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'discounted_price' => ['required', 'numeric', 'min:0'],
            'discount_start_at' => ['nullable', 'date'],
            'discount_end_at' => ['nullable', 'date'],
        ]);

        $product->update($data);

        return back()->with('success', 'ডিসকাউন্ট আপডেট হয়েছে।');
    }

    /**
     * Apply a percentage discount to multiple selected products.
     */
    public function bulkUpdate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['integer', 'exists:products,id'],
            'discount_percent' => ['required', 'numeric', 'min:1', 'max:99'],
            'discount_start_at' => ['nullable', 'date'],
            'discount_end_at' => ['nullable', 'date'],
        ]);

        $products = Product::whereIn('id', $data['product_ids'])->get();

        foreach ($products as $product) {
            $discountedPrice = round($product->price * (1 - $data['discount_percent'] / 100));

            $product->update([
                'discounted_price' => $discountedPrice,
                'discount_start_at' => $data['discount_start_at'] ?? null,
                'discount_end_at' => $data['discount_end_at'] ?? null,
            ]);
        }

        return back()->with('success', "{$products->count()}টি পণ্যে ডিসকাউন্ট প্রয়োগ হয়েছে।");
    }
}
