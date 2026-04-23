<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * List all categories with pagination.
     */
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->with('children')
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the create category form.
     */
    public function create(): View
    {
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a new category.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']).'-'.Str::random(4);
        $data['is_active'] = $request->boolean('is_active');

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটেগরি সফলভাবে যোগ করা হয়েছে।');
    }

    /**
     * Show the edit category form.
     */
    public function edit(Category $category): View
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update an existing category.
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? $category->slug;
        $data['is_active'] = $request->boolean('is_active');

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটেগরি সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটেগরি মুছে ফেলা হয়েছে।');
    }
}
