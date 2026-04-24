@extends('layouts.app')

@section('title', 'শপিং কার্ট')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">শপিং কার্ট</h1>

    @if(empty($items))
        <div class="text-center py-20">
            <svg class="mx-auto w-20 h-20 text-gray-200 mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.876-7.153A60.373 60.373 0 0 0 4.5 5.25H3.106L2.25 3z"/>
            </svg>
            <h2 class="text-xl font-semibold text-gray-600 mb-2">কার্ট খালি আছে</h2>
            <p class="text-gray-400 mb-6">পছন্দের পণ্য কার্টে যোগ করুন।</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold px-8 py-3 rounded-full transition-colors">পণ্য দেখুন</a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Cart Items --}}
            <div class="flex-1 space-y-4">
                @foreach($items as $item)
                <div class="bg-white rounded-2xl border border-gray-100 p-4 flex gap-4 shadow-sm">
                    {{-- Image --}}
                    <a href="{{ route('products.show', $item['product']) }}" class="shrink-0">
                        <img src="{{ $item['product']->primary_image }}" alt="{{ $item['product']->name }}"
                             class="w-20 h-20 rounded-xl object-cover bg-gray-50">
                    </a>

                    {{-- Details --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('products.show', $item['product']) }}" class="font-semibold text-gray-900 hover:text-amber-600 transition-colors text-sm leading-tight block mb-1 line-clamp-2">
                            {{ $item['product']->name }}
                        </a>

                        {{-- Size & Color Selectors --}}
                        <div class="mb-2 flex gap-2 flex-wrap">
                            {{-- Size Selector --}}
                            <form action="{{ route('cart.update-attributes', $item['key']) }}" method="POST" class="flex items-center gap-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="color" value="{{ $item['color'] }}">
                                <select name="size" onchange="this.form.submit()"
                                        class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-amber-400">
                                    @foreach(($item['product']->sizes ?? []) as $size)
                                        @if(($size['stock'] ?? 0) > 0)
                                            <option value="{{ $size['size'] }}" {{ $item['size'] === $size['size'] ? 'selected' : '' }}>
                                                {{ $size['size'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </form>

                            {{-- Color Selector --}}
                            @if(!empty($item['product']->colors))
                                <form action="{{ route('cart.update-attributes', $item['key']) }}" method="POST" class="flex items-center gap-1">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="size" value="{{ $item['size'] }}">
                                    <select name="color" onchange="this.form.submit()"
                                            class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-amber-400">
                                        @foreach($item['product']->colors as $color)
                                            <option value="{{ $color }}" {{ $item['color'] === $color ? 'selected' : '' }}>{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </div>

                        <div class="flex items-center justify-between flex-wrap gap-2">
                            {{-- Qty updater --}}
                            <form action="{{ route('cart.update', $item['key']) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <button type="button" onclick="this.form.qty.value=Math.max(0,+this.form.qty.value-1);this.form.submit()"
                                        class="w-7 h-7 rounded-full border border-gray-300 text-sm flex items-center justify-center hover:bg-gray-100">−</button>
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="0"
                                       class="w-12 text-center border border-gray-300 rounded-lg text-sm py-0.5 focus:outline-none focus:ring-2 focus:ring-amber-400">
                                <button type="button" onclick="this.form.qty.value=+this.form.qty.value+1;this.form.submit()"
                                        class="w-7 h-7 rounded-full border border-gray-300 text-sm flex items-center justify-center hover:bg-gray-100">+</button>
                            </form>

                            <div class="text-right">
                                <p class="font-bold text-gray-900">৳{{ number_format($item['line_total'], 0) }}</p>
                                <p class="text-xs text-gray-400">৳{{ number_format($item['unit_price'], 0) }} × {{ $item['qty'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Remove --}}
                    <form action="{{ route('cart.remove', $item['key']) }}" method="POST" class="shrink-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-1" title="সরান">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-72 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-20">
                    <h2 class="font-bold text-gray-900 text-lg mb-5">অর্ডার সারসংক্ষেপ</h2>

                    @php
                        $baseDeliveryCharge = (float)\App\Models\Setting::get('delivery_charge', 80);
                        $deliveryCharge = count($items) > 1 ? 0 : $baseDeliveryCharge;
                    @endphp

                    <div class="space-y-3 text-sm mb-5">
                        <div class="flex justify-between text-gray-600">
                            <span>সাবটোটাল</span>
                            <span class="font-medium">৳{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>ডেলিভারি চার্জ</span>
                            @if($deliveryCharge === 0)
                                <span class="font-medium text-green-600">ফ্রি!</span>
                            @else
                                <span class="font-medium">৳0</span>
                            @endif
                        </div>
                        @if($deliveryCharge === 0 && count($items) > 1)
                            <p class="text-xs text-green-600 flex items-center gap-1">
                                <i class='bx bxs-gift text-sm'></i>
                                {{ count($items) }}টি পণ্যের জন্য ফ্রি ডেলিভারি!
                            </p>
                        @endif
                        <div class="border-t border-gray-100 pt-3 flex justify-between font-bold text-gray-900 text-base">
                            <span>মোট</span>
                            <span>৳{{ number_format($subtotal + $deliveryCharge, 0) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                       class="block w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-center transition-colors shadow-md hover:shadow-lg">
                        চেকআউট করুন →
                    </a>

                    <a href="{{ route('products.index') }}" class="block text-center text-sm text-gray-400 hover:text-amber-500 mt-3 transition-colors">
                        কেনাকাটা অব্যাহত রাখুন
                    </a>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection
