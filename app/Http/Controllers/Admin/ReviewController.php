<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Show all reviews with their status.
     */
    public function index(): View
    {
        $reviews = Review::with('product:id,name,slug')
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Approve a pending review.
     */
    public function approve(Review $review): RedirectResponse
    {
        $review->update(['status' => 'approved']);

        return back()->with('success', 'রিভিউ অনুমোদন করা হয়েছে।');
    }

    /**
     * Reject a review.
     */
    public function reject(Review $review): RedirectResponse
    {
        $review->update(['status' => 'rejected']);

        return back()->with('success', 'রিভিউ প্রত্যাখ্যান করা হয়েছে।');
    }

    /**
     * Delete a review permanently.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'রিভিউ মুছে ফেলা হয়েছে।');
    }
}
