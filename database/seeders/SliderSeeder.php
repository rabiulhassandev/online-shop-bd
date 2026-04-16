<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Seed sample hero sliders.
     */
    public function run(): void
    {
        $sliders = [
            [
                'image' => 'sliders/slider-1.jpg',
                'title' => 'নতুন কালেকশন ২০২৬',
                'subtitle' => 'প্রিমিয়াম কোয়ালিটির শার্ট, সাশ্রয়ী মূল্যে',
                'button_text' => 'শপ নাও',
                'button_link' => '/products',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'image' => 'sliders/slider-2.jpg',
                'title' => 'সামার সেল — ৪০% পর্যন্ত ছাড়',
                'subtitle' => 'সীমিত সময়ের অফার। তাড়াতাড়ি অর্ডার করুন!',
                'button_text' => 'অফার দেখুন',
                'button_link' => '/products',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'image' => 'sliders/slider-3.jpg',
                'title' => 'ফ্রি ডেলিভারি ঢাকায়',
                'subtitle' => '৯৯৯৳ এর উপরে অর্ডারে বিনামূল্যে ডেলিভারি',
                'button_text' => 'বিস্তারিত',
                'button_link' => '/products',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(
                ['sort_order' => $slider['sort_order']],
                $slider
            );
        }
    }
}
