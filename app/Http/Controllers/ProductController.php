<?php

namespace App\Http\Controllers;

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

        // Sorting
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'discount' => $query->orderByDesc('discounted_price'),
            default => $query->latest(),
        };

        $products = $query->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    /**
     * Show a single product detail page.
     */
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('approvedReviews');

        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
