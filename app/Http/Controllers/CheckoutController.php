<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Division;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService,
    ) {}

    /**
     * Show the checkout form (cart-based).
     */
    public function index(): View|RedirectResponse
    {
        $items = $this->cartService->hydratedItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'কার্ট খালি আছে।');
        }

        $subtotal = $this->cartService->subtotal();
        $baseDeliveryCharge = (float) Setting::get('delivery_charge', 80);
        $deliveryCharge = count($items) > 1 ? 0 : $baseDeliveryCharge;
        $total = $subtotal + $deliveryCharge;
        $paymentMethods = $this->enabledPaymentMethods();
        $divisions = Division::active()->orderBy('name')->get(['id', 'name', 'bn_name']);

        return view('checkout.index', compact('items', 'subtotal', 'deliveryCharge', 'total', 'paymentMethods', 'divisions'));
    }

    /**
     * Show the checkout form pre-filled for an "Order Now" single product.
     */
    public function orderNow(Request $request): View|RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'size' => ['required', 'string'],
            'color' => ['nullable', 'string'],
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);
        $size = $request->size;
        $color = $request->string('color', '');
        $qty = (int) $request->get('qty', 1);

        $unitPrice = $product->hasActiveDiscount()
            ? (float) $product->discounted_price
            : (float) $product->price;

        $subtotal = $unitPrice * $qty;
        $deliveryCharge = (float) Setting::get('delivery_charge', 80);
        $total = $subtotal + $deliveryCharge;
        $paymentMethods = $this->enabledPaymentMethods();
        $divisions = Division::active()->orderBy('name')->get(['id', 'name', 'bn_name']);

        // Build a fake single-item array for the view
        $items = [[
            'product' => $product,
            'size' => $size,
            'color' => $color,
            'qty' => $qty,
            'unit_price' => $unitPrice,
            'line_total' => $subtotal,
        ]];

        return view('checkout.index', compact(
            'items', 'subtotal', 'deliveryCharge', 'total', 'paymentMethods',
            'product', 'size', 'color', 'qty', 'divisions'
        ));
    }

    /**
     * Process a cart-based checkout submission.
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $items = $this->cartService->hydratedItems();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'কার্ট খালি আছে।');
        }

        $order = $this->orderService->createFromCart($request->validated(), $items);
        $this->cartService->clear();

        return redirect()->route('checkout.confirmation', $order->id);
    }

    /**
     * Process an "Order Now" submission (single product, skips cart).
     */
    public function storeOrderNow(CheckoutRequest $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'size' => ['required', 'string'],
            'color' => ['nullable', 'string'],
            'qty' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);

        $order = $this->orderService->createSingleProduct(
            customerData: $request->validated(),
            product: $product,
            size: $request->size,
            color: $request->string('color', ''),
            qty: (int) $request->get('qty', 1),
        );

        return redirect()->route('checkout.confirmation', $order->id);
    }

    /**
     * Show the order confirmation page.
     */
    public function confirmation(Order $order): View
    {
        return view('checkout.confirmation', compact('order'));
    }

    /**
     * Display the invoice for download/print.
     */
    public function invoice(Order $order): View
    {
        return view('checkout.invoice', compact('order'));
    }

    /**
     * Get enabled payment methods from settings.
     *
     * @return array<string, string>
     */
    private function enabledPaymentMethods(): array
    {
        $methods = [];

        if (Setting::get('cod_enabled') === '1') {
            $methods['cod'] = 'ক্যাশ অন ডেলিভারি (COD)';
        }
        if (Setting::get('bkash_enabled') === '1') {
            $methods['bkash'] = 'বিকাশ (bKash)';
        }
        if (Setting::get('nagad_enabled') === '1') {
            $methods['nagad'] = 'নগদ (Nagad)';
        }

        return $methods;
    }
}
