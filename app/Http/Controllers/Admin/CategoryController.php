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
        $query = Category::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->withCount('products')
            ->with(['parent:id,name', 'children' => fn ($q) => $q->withCount('products')])
            ->orderBy('parent_id')
            ->orderBy('sort_order');

        $categories = $query->paginate(50)->withQueryString();

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
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        // check if slug already exists
        if (Category::where('slug', $data['slug'])->exists()) {
            return back()->withInput()->withErrors(['slug' => 'এই স্লাগটি ইতিমধ্যে ব্যবহার করা হয়েছে। অনুগ্রহ করে একটি অনন্য স্লাগ প্রদান করুন।']);
        }

        try {
            Category::create($data);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'ক্যাটেগরি তৈরি করতে সমস্যা হয়েছে: '.$e->getMessage(),
            ]);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'ক্যাটেগরি সফলভাবে যোগ করা হয়েছে।');
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
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        try {
            $category->update($data);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'ক্যাটেগরি আপডেট করতে সমস্যা হয়েছে: '.$e->getMessage()]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটেগরি সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'ক্যাটেগরি মুছে ফেলতে সমস্যা হয়েছে: '.$e->getMessage()]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'ক্যাটেগরি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
