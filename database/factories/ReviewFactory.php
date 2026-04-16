<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'reviewer_name' => fake()->randomElement([
                'রাহুল ইসলাম',
                'তানভীর আহমেদ',
                'সাকিব হাসান',
                'ফারহানা আক্তার',
                'মোহাম্মদ আলী',
                'নাফিসা জাহান',
                'আরিফুল ইসলাম',
                'সাদিয়া রহমান',
                'কামরুল হাসান',
                'জান্নাতুল ফেরদৌস',
            ]),
            'rating' => fake()->numberBetween(3, 5),
            'comment' => fake()->randomElement([
                'অসাধারণ কোয়ালিটি! টাকার বিনিময়ে দারুণ ভ্যালু পেয়েছি।',
                'ফ্যাব্রিক খুবই আরামদায়ক। আবার অর্ডার করবো।',
                'ডেলিভারি দ্রুত ছিল এবং প্রোডাক্ট ছবির মতোই।',
                'সাইজ একদম পারফেক্ট। খুবই সন্তুষ্ট।',
                'দারুণ ডিজাইন, ভালো মান। রিকমেন্ড করছি।',
                'এই দামে এতো ভালো শার্ট পাওয়া রেয়ার। ধন্যবাদ কাতুয়া শার্ট!',
                'কালার একটু ভিন্ন লাগলো, তবে কোয়ালিটি ভালো।',
                'তৃতীয়বার অর্ডার করলাম। প্রতিবারই মান ভালো পাচ্ছি।',
                'শার্টের ফিটিং দারুণ। অফিসে সবাই প্রশংসা করলো।',
                'পরিবারের জন্য ৫টা নিলাম, সবাই খুশি!',
            ]),
            'status' => fake()->randomElement(['approved', 'approved', 'approved', 'pending']),
        ];
    }

    /**
     * Set review as approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'approved',
        ]);
    }
}
