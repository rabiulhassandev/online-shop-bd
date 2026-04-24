@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 160))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-amber-500">হোম</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-amber-500">পণ্য</a>
        @if($product->category)
            <span>/</span>
            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-amber-500">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span class="text-gray-900">{{ Str::limit($product->name, 40) }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">

        {{-- Image Gallery --}}
        <div x-data="{ active: 0, images: {{ json_encode(array_map(fn($img) => asset('storage/'.$img), $product->images ?? [])) }} }">
            {{-- Main image --}}
            <div class="product-image-wrap rounded-2xl overflow-hidden bg-gray-50 aspect-square mb-3 border border-gray-100">
                <img :src="images[active] || '{{ $product->primary_image }}'" alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- Thumbnails --}}
            @if(count($product->images ?? []) > 1)
            <div class="flex gap-2 overflow-x-auto pb-1">
                @foreach($product->images as $i => $img)
                <button @click="active = {{ $i }}"
                        :class="active === {{ $i }} ? 'ring-2 ring-amber-500' : 'ring-1 ring-gray-200'"
                        class="shrink-0 w-16 h-16 rounded-lg overflow-hidden transition-all">
                    <img src="{{ asset('storage/'.$img) }}" alt="" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div x-data="{
            selectedSize: '',
            selectedColor: '',
            qty: 1,
            sizes: {{ json_encode($product->sizes ?? []) }},
            colors: {{ json_encode($product->colors ?? []) }},
        }">
            {{-- Name --}}
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-3">{{ $product->name }}</h1>

            {{-- Category --}}
            @if($product->category)
                <div class="mb-4">
                    <span class="text-sm text-gray-500">ক্যাটাগরি:</span>
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-sm font-medium text-amber-600 hover:underline ml-1">
                        {{ $product->category->name }}
                        @if($product->category->parent)
                            <span class="text-gray-400"> → {{ $product->category->parent->name }}</span>
                        @endif
                    </a>
                </div>
            @endif

            {{-- Discount badge + timer --}}
            @if($product->hasActiveDiscount())
            <div class="flex items-center gap-3 mb-4" data-discount-badge>
                <span class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full">{{ $product->discount_percent }}% ছাড়</span>
                @if($product->discount_end_at)
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">অফার শেষ:</span>
                        <span class="font-mono font-semibold text-red-600 ml-1" data-countdown="{{ $product->discount_end_at->timestamp }}"></span>
                    </div>
                @endif
            </div>
            @endif

            {{-- Price --}}
            <div class="flex items-baseline gap-3 mb-6">
                <span class="text-3xl font-bold text-gray-900">৳{{ number_format($product->effective_price, 0) }}</span>
                @if($product->hasActiveDiscount())
                    <span class="text-lg text-gray-400 line-through">৳{{ number_format($product->price, 0) }}</span>
                @endif
            </div>

            <!-- add alert -->
            <div class="bg-amber-100 border border-amber-400 text-amber-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">অফার নিশ্চিত করুন!</strong>
                <span class="block sm:inline">{{ \App\Models\Setting::get('product_promo_text', 'এই পণ্যটির উপর প্রযোজ্য অফার আছে।') }}</span>
            </div>

            {{-- Size Selector --}}
            @if(!empty($product->sizes))
            <div class="mb-5">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-semibold text-gray-800">সাইজ বেছে নিন</label>
                    <span class="text-xs text-amber-500 font-medium" x-show="selectedSize">নির্বাচিত: <span x-text="selectedSize"></span></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->sizes as $sizeItem)
                        @php $outOfStock = ($sizeItem['stock'] ?? 0) <= 0; @endphp
                        <button
                            type="button"
                            @click="{{ !$outOfStock ? 'selectedSize = \'' . $sizeItem['size'] . '\'' : '' }}"
                            :class="{
                                'bg-gray-900 text-white border-gray-900': selectedSize === '{{ $sizeItem['size'] }}',
                                'border-gray-300 text-gray-900 hover:border-gray-900': selectedSize !== '{{ $sizeItem['size'] }}' && !{{ $outOfStock ? 'true' : 'false' }},
                                'border-gray-200 text-gray-300 cursor-not-allowed line-through': {{ $outOfStock ? 'true' : 'false' }},
                            }"
                            class="w-12 h-10 rounded-lg border text-sm font-medium transition-all"
                            {{ $outOfStock ? 'disabled' : '' }}>
                            {{ $sizeItem['size'] }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Color Selector --}}
            @if(!empty($product->colors))
            <div class="mb-5">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-semibold text-gray-800">কালার বেছে নিন</label>
                    <span class="text-xs text-amber-500" x-show="selectedColor" x-text="selectedColor"></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($product->colors as $color)
                    <button type="button"
                            @click="selectedColor = '{{ $color }}'"
                            :class="selectedColor === '{{ $color }}' ? 'ring-2 ring-amber-500 ring-offset-1' : ''"
                            class="px-4 py-1.5 rounded-full border border-gray-300 text-sm hover:border-gray-900 transition-all">
                        {{ $color }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Quantity --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-800 mb-2">পরিমাণ</label>
                <div class="flex items-center gap-3">
                    <button type="button" @click="if(qty > 1) qty--"
                            class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-lg font-medium hover:bg-gray-100 transition-colors">−</button>
                    <span class="w-10 text-center font-semibold text-lg" x-text="qty"></span>
                    <button type="button" @click="if(qty < {{ $product->total_stock }}) qty++"
                            class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-lg font-medium hover:bg-gray-100 transition-colors">+</button>
                    <span class="text-xs text-gray-400 ml-2">স্টক: {{ $product->total_stock }} টি</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">
                {{-- Add to Cart --}}
                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="size" :value="selectedSize">
                    <input type="hidden" name="color" :value="selectedColor">
                    <input type="hidden" name="qty" :value="qty">
                    <button type="submit"
                            class="w-full py-3 px-6 rounded-xl border-2 border-gray-900 text-gray-900 font-semibold hover:bg-gray-900 hover:text-white transition-all duration-200">
                        🛒 কার্টে যোগ করুন
                    </button>
                </form>

                {{-- Order Now --}}
                <form action="{{ route('checkout.store-order-now') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="size" :value="selectedSize">
                    <input type="hidden" name="color" :value="selectedColor">
                    <input type="hidden" name="qty" :value="qty">
                    <button type="submit"
                            class="w-full py-3 px-6 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                        ⚡ এখনই অর্ডার করুন
                    </button>
                </form>
            </div>

            <!-- Product Chart Image (public/assets/images/product-chart.jpeg) -->
            <div class="mt-10">
                <img src="{{ asset('assets/images/product-chart.jpeg') }}" alt="Product Chart" class="w-full rounded-lg border border-gray-200">
            </div>
        </div>
    </div>

    <div class="py-2">
        {{-- Description --}}
        @if($product->description)
        <div class="text-gray-600 leading-relaxed mb-6 text-sm prose prose-sm prose-a:text-amber-500 max-w-none">
            {!! $product->description !!}
        </div>
        @endif
    </div>

    {{-- Reviews Section --}}
    <div class="mt-16 border-t border-gray-100 pt-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">কাস্টমার রিভিউ</h2>

        @if($product->approvedReviews->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
            @foreach($product->approvedReviews as $review)
            <div class="bg-gray-50 rounded-xl p-5">
                <div class="flex gap-0.5 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-sm text-gray-700 mb-3 leading-relaxed">"{{ $review->comment }}"</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span class="font-semibold text-gray-800">{{ $review->reviewer_name }}</span>
                    <span>{{ $review->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <p class="text-gray-400 text-sm mb-8">এখনো কোনো রিভিউ নেই। প্রথম রিভিউ লিখুন!</p>
        @endif

        {{-- Review Form --}}
        <div class="bg-gray-50 rounded-2xl p-6 max-w-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">রিভিউ লিখুন</h3>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('reviews.store', $product) }}" method="POST" x-data="{ rating: 0 }">
                @csrf

                {{-- Star Rating --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">রেটিং দিন</label>
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" @click="rating = {{ $i }}"
                                class="text-3xl transition-transform hover:scale-110"
                                :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-gray-300'">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" :value="rating">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">আপনার নাম *</label>
                    <input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">মন্তব্য *</label>
                    <textarea name="comment" rows="3" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ old('comment') }}</textarea>
                </div>

                <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition-colors">রিভিউ জমা দিন</button>
            </form>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count())
    <div class="mt-14">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">আরও দেখুন</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($relatedProducts as $related)
                <x-product-card :product="$related"/>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
