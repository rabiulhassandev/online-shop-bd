<?php

namespace App\Http\Controllers;

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
            ->with('approvedReviews')
            ->latest()
            ->limit(8)
            ->get();

        $newArrivals = Product::active()
            ->newArrival()
            ->latest()
            ->limit(8)
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
            'testimonials',
            'whatsapp',
            'phone',
            'facebook',
        ));
    }
}
