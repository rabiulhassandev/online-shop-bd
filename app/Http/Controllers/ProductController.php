<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Show paginated product listing with sort and filter.
     */
    public function index(Request $request): View
    {
        $query = Product::active();
        $listing = $request->string('listing')->toString();

        // Search by name or description
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by size availability (JSON contains check)
        if ($request->filled('size')) {
            $query->whereJsonContains('sizes', ['size' => $request->size]);
        }

        // Filter by category slug
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)
                    ->orWhereHas('parent', function ($p) use ($request) {
                        $p->where('slug', $request->category);
                    });
            });
        }

        if ($listing === 'hot') {
            $soldQuantities = [];
            $orderItems = Order::query()
                ->where('status', '!=', 'cancelled')
                ->pluck('items');

            foreach ($orderItems as $items) {
                foreach ($items as $item) {
                    if (! isset($item['product_id'])) {
                        continue;
                    }

                    $productId = (int) $item['product_id'];
                    $quantity = (int) ($item['qty'] ?? 0);
                    $soldQuantities[$productId] = ($soldQuantities[$productId] ?? 0) + $quantity;
                }
            }

            arsort($soldQuantities);
            $productIds = array_keys($soldQuantities);

            if (empty($productIds)) {
                $query->whereRaw('1 = 0');
            } else {
                $orderedIds = implode(',', $productIds);
                $query->whereIn('id', $productIds)
                    ->orderByRaw("FIELD(id, {$orderedIds})");
            }
        } else {
            if ($listing === 'discount') {
                $now = now();
                $query->whereNotNull('discounted_price')
                    ->whereColumn('discounted_price', '<', 'price')
                    ->where(function ($q) use ($now) {
                        $q->whereNull('discount_start_at')
                            ->orWhere('discount_start_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('discount_end_at')
                            ->orWhere('discount_end_at', '>=', $now);
                    })
                    ->orderByRaw('((price - discounted_price) / price) DESC');
            }

            // Sorting
            $sort = $request->get('sort', 'newest');
            match ($sort) {
                'price_asc' => $query->orderBy('price'),
                'price_desc' => $query->orderByDesc('price'),
                'discount' => $query->orderByDesc('discounted_price'),
                default => $query->latest(),
            };
        }

        $products = $query->with('category')->paginate(10)->withQueryString();

        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show a single product detail page.
     */
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load(['approvedReviews', 'category']);

        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->with('category')
            ->latest()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
