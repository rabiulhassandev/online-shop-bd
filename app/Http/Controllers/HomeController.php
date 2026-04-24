<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the homepage with sliders, featured products, new arrivals, and testimonials.
     */
    public function index(): View
    {
        $sliders = Slider::active()->get();

        $featuredProducts = Product::active()
            ->featured()
            ->with(['approvedReviews', 'category'])
            ->latest()
            ->limit(8)
            ->get();

        $newArrivals = Product::active()
            ->newArrival()
            ->with('category')
            ->latest()
            ->limit(8)
            ->get();

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->get();

        $testimonials = Review::approved()
            ->with('product:id,name,slug')
            ->where('rating', '>=', 4)
            ->latest()
            ->limit(6)
            ->get();

        $whatsapp = Setting::get('whatsapp', '8801700000000');
        $phone = Setting::get('phone', '01700000000');
        $facebook = Setting::get('facebook_url', '#');

        return view('home', compact(
            'sliders',
            'featuredProducts',
            'newArrivals',
            'categories',
            'testimonials',
            'whatsapp',
            'phone',
            'facebook',
        ));
    }

    /**
     * Show the about us page.
     */
    public function about(): View
    {
        $aboutUs = Setting::get('about_us', '<p>আমাদের সম্পর্কে তথ্য শীঘ্রই যুক্ত করা হবে।</p>');
        $siteName = Setting::get('site_name', 'কাতুয়া শার্ট');

        return view('about', compact('aboutUs', 'siteName'));
    }

    /**
     * Show the terms & conditions page.
     */
    public function terms(): View
    {
        $content = Setting::get('terms_and_conditions', '<p>শর্তাবলী শীঘ্রই যুক্ত করা হবে।</p>');
        $siteName = Setting::get('site_name', 'কাতুয়া শার্ট');

        return view('terms', compact('content', 'siteName'));
    }

    /**
     * Show the return policy page.
     */
    public function returnPolicy(): View
    {
        $content = Setting::get('return_policy', '<p>রিটার্ন পলিসি শীঘ্রই যুক্ত করা হবে।</p>');
        $siteName = Setting::get('site_name', 'কাতুয়া শার্ট');

        return view('return-policy', compact('content', 'siteName'));
    }

    /**
     * Show all approved customer reviews.
     */
    public function reviews(): View
    {
        $reviews = Review::approved()
            ->with('product:id,name,slug')
            ->latest()
            ->paginate(12);

        return view('reviews', compact('reviews'));
    }
}
