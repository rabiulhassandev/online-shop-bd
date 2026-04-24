<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    /** @var string */
    private const SESSION_KEY = 'cart';

    /**
     * Get all items currently in cart.
     *
     * @return array<int, array{product_id: int, size: string, color: string, qty: int}>
     */
    public function getItems(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Add a product to the cart or increment quantity if same size+color.
     */
    public function add(int $productId, string $size, string $color, int $qty = 1): void
    {
        $items = $this->getItems();
        $key = $this->itemKey($productId, $size, $color);

        if (isset($items[$key])) {
            $items[$key]['qty'] += $qty;
        } else {
            $items[$key] = [
                'product_id' => $productId,
                'size' => $size,
                'color' => $color,
                'qty' => $qty,
            ];
        }

        Session::put(self::SESSION_KEY, $items);
    }

    /**
     * Update quantity for a specific cart item.
     */
    public function update(string $key, int $qty): void
    {
        $items = $this->getItems();

        if ($qty <= 0) {
            unset($items[$key]);
        } else {
            $items[$key]['qty'] = $qty;
        }

        Session::put(self::SESSION_KEY, $items);
    }

    /**
     * Remove a specific item from cart by key.
     */
    public function remove(string $key): void
    {
        $items = $this->getItems();
        unset($items[$key]);
        Session::put(self::SESSION_KEY, $items);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Get total number of items (counting qty) in the cart.
     */
    public function count(): int
    {
        return array_sum(array_column($this->getItems(), 'qty'));
    }

    /**
     * Get number of unique items in the cart.
     */
    public function uniqueCount(): int
    {
        return count($this->getItems());
    }

    /**
     * Get cart items hydrated with product data.
     *
     * @return array<int, array{key: string, product: Product, size: string, color: string, qty: int, unit_price: float, line_total: float}>
     */
    public function hydratedItems(): array
    {
        $items = $this->getItems();

        if (empty($items)) {
            return [];
        }

        $productIds = array_unique(array_column($items, 'product_id'));
        $products = Product::whereIn('id', $productIds)
            ->select(['id', 'name', 'slug', 'images', 'price', 'discounted_price', 'discount_start_at', 'discount_end_at'])
            ->get()
            ->keyBy('id');

        $hydrated = [];
        foreach ($items as $key => $item) {
            $product = $products->get($item['product_id']);

            if (! $product) {
                continue;
            }

            $unitPrice = $product->hasActiveDiscount()
                ? (float) $product->discounted_price
                : (float) $product->price;

            $hydrated[] = [
                'key' => $key,
                'product' => $product,
                'size' => $item['size'],
                'color' => $item['color'],
                'qty' => $item['qty'],
                'unit_price' => $unitPrice,
                'line_total' => $unitPrice * $item['qty'],
            ];
        }

        return $hydrated;
    }

    /**
     * Calculate the subtotal of all cart items.
     */
    public function subtotal(): float
    {
        return (float) array_sum(array_column($this->hydratedItems(), 'line_total'));
    }

    /**
     * Generate a unique key for a cart item based on product+size+color.
     */
    private function itemKey(int $productId, string $size, string $color): string
    {
        return "{$productId}_{$size}_{$color}";
    }
}
