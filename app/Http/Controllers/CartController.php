<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    /**
     * Show the shopping cart.
     */
    public function index(): View
    {
        $items = $this->cartService->hydratedItems();
        $subtotal = $this->cartService->subtotal();

        return view('cart.index', compact('items', 'subtotal'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'size' => ['required', 'string'],
            'color' => ['nullable', 'string'],
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $this->cartService->add(
            productId: (int) $request->product_id,
            size: $request->size,
            color: $request->string('color', ''),
            qty: (int) $request->get('qty', 1),
        );

        return back()->with('success', 'পণ্য কার্টে যোগ হয়েছে।');
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request, string $key): RedirectResponse
    {
        $request->validate([
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        $this->cartService->update($key, (int) $request->qty);

        return back()->with('success', 'কার্ট আপডেট হয়েছে।');
    }

    /**
     * Remove a specific item from the cart.
     */
    public function remove(string $key): RedirectResponse
    {
        $this->cartService->remove($key);

        return back()->with('success', 'পণ্য কার্ট থেকে সরানো হয়েছে।');
    }

    /**
     * Get the current cart item count (for navbar badge via JS).
     */
    public function count(): JsonResponse
    {
        return response()->json(['count' => $this->cartService->count()]);
    }
}
