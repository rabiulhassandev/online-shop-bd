<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;

class OrderService
{
    /**
     * Create a new order from cart items and checkout data.
     *
     * @param  array{customer_name: string, phone: string, address: string, payment_method: string}  $customerData
     * @param  array<int, array{key: string, product: Product, size: string, color: string, qty: int, unit_price: float, line_total: float}>  $hydratedItems
     */
    public function createFromCart(array $customerData, array $hydratedItems): Order
    {
        $deliveryCharge = (float) Setting::get('delivery_charge', 80);
        $subtotal = (float) array_sum(array_column($hydratedItems, 'line_total'));
        $total = $subtotal + $deliveryCharge;

        $itemsSnapshot = array_map(fn (array $item): array => [
            'product_id' => $item['product']->id,
            'product_name' => $item['product']->name,
            'image' => $item['product']->primary_image,
            'size' => $item['size'],
            'color' => $item['color'],
            'qty' => $item['qty'],
            'unit_price' => $item['unit_price'],
            'line_total' => $item['line_total'],
        ], $hydratedItems);

        return Order::create([
            'customer_name' => $customerData['customer_name'],
            'phone' => $customerData['phone'],
            'address' => $customerData['address'],
            'items' => array_values($itemsSnapshot),
            'subtotal' => $subtotal,
            'delivery_charge' => $deliveryCharge,
            'total' => $total,
            'payment_method' => $customerData['payment_method'],
            'status' => 'pending',
        ]);
    }

    /**
     * Create a quick "Order Now" order for a single product.
     *
     * @param  array{customer_name: string, phone: string, address: string, payment_method: string}  $customerData
     */
    public function createSingleProduct(
        array $customerData,
        Product $product,
        string $size,
        string $color,
        int $qty
    ): Order {
        $deliveryCharge = (float) Setting::get('delivery_charge', 80);
        $unitPrice = $product->hasActiveDiscount()
            ? (float) $product->discounted_price
            : (float) $product->price;

        $subtotal = $unitPrice * $qty;
        $total = $subtotal + $deliveryCharge;

        return Order::create([
            'customer_name' => $customerData['customer_name'],
            'phone' => $customerData['phone'],
            'address' => $customerData['address'],
            'items' => [[
                'product_id' => $product->id,
                'product_name' => $product->name,
                'image' => $product->primary_image,
                'size' => $size,
                'color' => $color,
                'qty' => $qty,
                'unit_price' => $unitPrice,
                'line_total' => $subtotal,
            ]],
            'subtotal' => $subtotal,
            'delivery_charge' => $deliveryCharge,
            'total' => $total,
            'payment_method' => $customerData['payment_method'],
            'status' => 'pending',
        ]);
    }
}
