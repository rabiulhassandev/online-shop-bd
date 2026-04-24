@props(['product'])

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col">
    {{-- Product Image --}}
    <a href="{{ route('products.show', $product) }}" class="product-image-wrap block aspect-[4/3] bg-gray-50">
        <img
            src="{{ $product->primary_image }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover"
            loading="lazy"
        >
    </a>

    <div class="p-4 flex flex-col flex-1">

        {{-- Discount Badge + Timer --}}
        @if($product->hasActiveDiscount())
            <div class="flex items-center gap-2 mb-2" data-discount-badge>
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $product->discount_percent }}% ছাড়
                </span>
                @if($product->discount_end_at)
                    <span class="text-xs text-gray-500 font-mono tabular-nums" data-countdown="{{ $product->discount_end_at->timestamp }}"></span>
                @endif
            </div>
        @endif

        {{-- Product Name --}}
        <a href="{{ route('products.show', $product) }}" class="font-semibold text-gray-900 hover:text-amber-600 transition-colors leading-tight mb-1 line-clamp-2">
            {{ $product->name }}
        </a>

        {{-- Price --}}
        <div class="flex items-center gap-2 mt-auto pt-2">
            <span class="text-lg font-bold text-gray-900">৳{{ number_format($product->effective_price, 0) }}</span>
            @if($product->hasActiveDiscount())
                <span class="text-sm text-gray-400 line-through">৳{{ number_format($product->price, 0) }}</span>
            @endif
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-2 mt-3">
            {{-- Add to Cart --}}
            <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size" value="{{ ($product->sizes[0]['size'] ?? 'M') }}">
                <input type="hidden" name="color" value="{{ ($product->colors[0] ?? '') }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit"
                        class="w-full text-xs font-medium px-3 py-2 rounded-lg border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition-colors duration-200">
                    কার্টে যোগ
                </button>
            </form>

            {{-- Order Now --}}
            <a href="{{ route('checkout.order-now', ['product_id' => $product->id, 'size' => ($product->sizes[0]['size'] ?? 'M'), 'color' => ($product->colors[0] ?? ''), 'qty' => 1]) }}"
               class="flex-1 text-xs font-medium px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-center transition-colors duration-200">
                এখনই অর্ডার
            </a>
        </div>
    </div>
</div>
