<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Store a new review for a product (pending by default).
     */
    public function store(ReviewRequest $request, Product $product): RedirectResponse
    {
        $product->reviews()->create([
            ...$request->validated(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'আপনার রিভিউ সফলভাবে জমা হয়েছে। অনুমোদনের পরে প্রকাশ পাবে।');
    }
}
