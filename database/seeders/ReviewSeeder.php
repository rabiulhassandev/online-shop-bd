<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Seed sample reviews for existing products.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products->random(min(12, $products->count())) as $product) {
            Review::factory()
                ->count(fake()->numberBetween(1, 4))
                ->create(['product_id' => $product->id]);
        }
    }
}
