@extends('layouts.app')

@section('title', 'অর্ডার নিশ্চিত')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-16 text-center">
    {{-- Success Icon --}}
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-2">অর্ডার সফল হয়েছে! ☺️</h1>
    <p class="text-gray-500 mb-1">আপনার অর্ডার নম্বর:</p>
    <div class="inline-block bg-amber-50 border border-amber-200 text-amber-700 font-mono font-bold text-xl px-6 py-3 rounded-xl mb-8">
        {{ $order->order_number }}
    </div>

    {{-- Order Details --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-left mb-8">
        <h2 class="font-bold text-gray-900 mb-4">অর্ডারের বিবরণ</h2>

        {{-- Items --}}
        <div class="space-y-3 mb-4">
            @foreach($order->items as $item)
            <div class="flex items-center gap-3">
                <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}"
                     class="w-14 h-14 rounded-xl object-cover bg-gray-50 shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm text-gray-900 line-clamp-1">{{ $item['product_name'] }}</p>
                    <p class="text-xs text-gray-400">{{ $item['size'] }} × {{ $item['qty'] }}</p>
                </div>
                <p class="font-bold text-sm text-gray-900">৳{{ number_format($item['line_total'], 0) }}</p>
            </div>
            @endforeach
        </div>

        <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600"><span>সাবটোটাল</span><span>৳{{ number_format($order->subtotal, 0) }}</span></div>
            <div class="flex justify-between text-gray-600"><span>ডেলিভারি চার্জ</span><span>৳{{ number_format($order->delivery_charge, 0) }}</span></div>
            <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-100 pt-2"><span>মোট</span><span>৳{{ number_format($order->total, 0) }}</span></div>
        </div>

        <div class="border-t border-gray-100 pt-4 mt-4 grid grid-cols-2 gap-3 text-sm">
            <div><p class="text-gray-400 text-xs mb-0.5">নাম</p><p class="font-medium text-gray-900">{{ $order->customer_name }}</p></div>
            <div><p class="text-gray-400 text-xs mb-0.5">ফোন</p><p class="font-medium text-gray-900">{{ $order->phone }}</p></div>
            <div class="col-span-2"><p class="text-gray-400 text-xs mb-0.5">ঠিকানা</p><p class="font-medium text-gray-900">{{ $order->address }}</p></div>
            @if($order->note)
                <div class="col-span-2"><p class="text-gray-400 text-xs mb-0.5">নোট</p><p class="font-medium text-gray-900 bg-gray-50 rounded-lg px-3 py-2">{{ $order->note }}</p></div>
            @endif
            <div><p class="text-gray-400 text-xs mb-0.5">পেমেন্ট</p><p class="font-medium text-gray-900 uppercase">{{ $order->payment_method }}</p></div>
            <div><p class="text-gray-400 text-xs mb-0.5">স্ট্যাটাস</p><span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">Pending</span></div>
        </div>
    </div>

    <p class="text-sm text-gray-500 mb-6">আমরা শীঘ্রই আপনাকে কল করে অর্ডার নিশ্চিত করব।</p>

    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('checkout.invoice', $order->id) }}"
           target="_blank"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition-colors">
            📥 ইনভয়েস ডাউনলোড
        </a>
        <a href="{{ route('products.index') }}"
           class="inline-block bg-gray-900 hover:bg-gray-700 text-white font-semibold px-8 py-3 rounded-full transition-colors">
            কেনাকাটা চালিয়ে যান
        </a>
    </div>
</div>
@endsection
