@extends('layouts.app')

@section('title', 'সব পণ্য')
@section('meta_description', 'কাতুয়া শার্টের সম্পূর্ণ কালেকশন দেখুন। ফিল্টার ও সর্ট করুন।')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">সব পণ্য</h1>
        <p class="text-gray-500 mt-1">{{ $products->total() }}টি পণ্য পাওয়া গেছে</p>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('products.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 mb-8 flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-medium text-gray-600 mb-1">ক্যাটাগরি</label>
            <select name="category" class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400">
                <option value="">সব ক্যাটাগরি</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @foreach($category->children as $child)
                        <option value="{{ $child->slug }}" {{ request('category') === $child->slug ? 'selected' : '' }}>└ {{ $child->name }}</option>
                    @endforeach
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-40">
            <label class="block text-xs font-medium text-gray-600 mb-1">সাইজ</label>
            <select name="size" class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400">
                <option value="">সব সাইজ</option>
                @foreach(['S','M','L','XL','XXL'] as $size)
                    <option value="{{ $size }}" {{ request('size') === $size ? 'selected' : '' }}>{{ $size }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-32">
            <label class="block text-xs font-medium text-gray-600 mb-1">সর্বনিম্ন দাম (৳)</label>
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="০" min="0"
                   class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <div class="flex-1 min-w-32">
            <label class="block text-xs font-medium text-gray-600 mb-1">সর্বোচ্চ দাম (৳)</label>
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="৫০০০" min="0"
                   class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400">
        </div>

        <div class="flex-1 min-w-40">
            <label class="block text-xs font-medium text-gray-600 mb-1">সাজানো</label>
            <select name="sort" class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-400">
                <option value="newest"    {{ request('sort','newest') === 'newest'    ? 'selected' : '' }}>নতুন আগে</option>
                <option value="price_asc" {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>দাম (কম-বেশি)</option>
                <option value="price_desc"{{ request('sort') === 'price_desc' ? 'selected' : '' }}>দাম (বেশি-কম)</option>
                <option value="discount"  {{ request('sort') === 'discount'   ? 'selected' : '' }}>সবচেয়ে বেশি ছাড়</option>
            </select>
        </div>

        <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">ফিল্টার করুন</button>
        @if(request()->hasAny(['category','size','min_price','max_price','sort']))
            <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">রিসেট</a>
        @endif
    </form>

    {{-- Product Grid --}}
    @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product"/>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <svg class="mx-auto w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">কোনো পণ্য পাওয়া যায়নি</h3>
            <p class="text-gray-400">অন্য ফিল্টার চেষ্টা করুন।</p>
        </div>
    @endif
</div>
@endsection
