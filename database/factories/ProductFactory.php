<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'ক্লাসিক ফরমাল শার্ট',
            'স্লিম ফিট ক্যাজুয়াল',
            'প্রিন্টেড হাফ স্লিভ',
            'সলিড কালার পোলো',
            'চেক প্যাটার্ন শার্ট',
            'লিনেন সামার শার্ট',
            'ডেনিম ক্যাজুয়াল শার্ট',
            'অক্সফোর্ড বাটন ডাউন',
            'ফ্লোরাল প্রিন্ট শার্ট',
            'স্ট্রাইপ ফরমাল শার্ট',
            'মেরুন এক্সক্লুসিভ',
            'নেভি ব্লু প্রিমিয়াম',
            'অলিভ গ্রিন ক্যাজুয়াল',
            'রয়েল ব্ল্যাক শার্ট',
            'স্কাই ব্লু কমফোর্ট',
            'চারকোল গ্রে ফিট',
            'ক্রিম কটন শার্ট',
            'পিচ সিল্ক ব্লেন্ড',
            'টিল গ্রিন প্রিমিয়াম',
            'বার্গান্ডি এলিট',
        ]);

        $price = fake()->randomElement([599, 699, 799, 899, 999, 1099, 1199, 1299, 1499, 1699]);
        $hasDiscount = fake()->boolean(60);
        $discountedPrice = $hasDiscount ? round($price * fake()->randomFloat(2, 0.6, 0.85)) : null;

        $sizes = [];
        foreach (['S', 'M', 'L', 'XL', 'XXL'] as $size) {
            if (fake()->boolean(75)) {
                $sizes[] = ['size' => $size, 'stock' => fake()->numberBetween(0, 25)];
            }
        }

        if (empty($sizes)) {
            $sizes[] = ['size' => 'M', 'stock' => fake()->numberBetween(5, 20)];
        }

        $totalStock = array_sum(array_column($sizes, 'stock'));

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(4),
            'description' => 'প্রিমিয়াম কোয়ালিটি '.$name.'। আরামদায়ক ফ্যাব্রিক এবং স্টাইলিশ ডিজাইন। সব সিজনে পরার উপযোগী।',
            'images' => [],
            'price' => $price,
            'discounted_price' => $discountedPrice,
            'discount_start_at' => $hasDiscount ? now()->subDays(fake()->numberBetween(1, 5)) : null,
            'discount_end_at' => $hasDiscount ? now()->addDays(fake()->numberBetween(3, 15)) : null,
            'sizes' => $sizes,
            'colors' => fake()->randomElements(['White', 'Black', 'Navy', 'Red', 'Green', 'Blue', 'Grey', 'Maroon', 'Olive'], fake()->numberBetween(2, 5)),
            'total_stock' => $totalStock,
            'is_featured' => fake()->boolean(35),
            'is_new_arrival' => fake()->boolean(30),
            'is_active' => true,
        ];
    }
}
