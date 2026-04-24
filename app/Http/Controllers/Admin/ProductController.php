<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * List all products with optional search and pagination.
     */
    public function index(Request $request): View
    {
        $products = Product::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the create product form.
     */
    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a new product.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']).'-'.Str::random(4);
        $data['images'] = $this->uploadImages($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['is_active'] = $request->boolean('is_active');
        $data['total_stock'] = $this->calculateStock($data['sizes'] ?? []);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'পণ্য সফলভাবে যোগ করা হয়েছে।');
    }

    /**
     * Show the edit product form.
     */
    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update an existing product.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? $product->slug;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_new_arrival'] = $request->boolean('is_new_arrival');
        $data['is_active'] = $request->boolean('is_active');
        $data['total_stock'] = $this->calculateStock($data['sizes'] ?? $product->sizes ?? []);

        // Merge new uploads with existing images
        $newImages = $this->uploadImages($request);
        $existingImages = $request->input('existing_images', []);
        $data['images'] = array_merge(
            is_array($existingImages) ? $existingImages : [],
            $newImages
        );

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'পণ্য সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'পণ্য মুছে ফেলা হয়েছে।');
    }

    /**
     * Upload product images and return relative paths.
     *
     * @return list<string>
     */
    private function uploadImages(Request $request): array
    {
        $paths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('products', 'public');
            }
        }

        return $paths;
    }

    /**
     * Sum up stock across all size entries.
     *
     * @param  array<int, array{size: string, stock: int}>  $sizes
     */
    private function calculateStock(array $sizes): int
    {
        return (int) array_sum(array_column($sizes, 'stock'));
    }
}
