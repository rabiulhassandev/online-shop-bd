@extends('layouts.admin')
@section('title', 'অর্ডার বিবরণ — '.$order->order_number)
@section('page-title', 'অর্ডার বিবরণ')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-amber-500 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        অর্ডার তালিকায় ফিরুন
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        {{-- Order Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-semibold text-gray-900 mb-4">অর্ডার তথ্য</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">অর্ডার #</dt><dd class="font-mono font-bold text-amber-600">{{ $order->order_number }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">তারিখ</dt><dd class="text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">পেমেন্ট</dt><dd class="uppercase font-medium text-gray-800">{{ $order->payment_method }}</dd></div>
            </dl>
        </div>
        {{-- Customer Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="font-semibold text-gray-900 mb-4">গ্রাহকের তথ্য</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">নাম</dt><dd class="text-gray-800 font-medium">{{ $order->customer_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">ফোন</dt><dd class="text-gray-800">{{ $order->phone }}</dd></div>
                <div><dt class="text-gray-500 mb-1">ঠিকানা</dt><dd class="text-gray-800">{{ $order->address }}</dd></div>
                @if($order->note)
                    <div><dt class="text-gray-500 mb-1">নোট</dt><dd class="text-gray-800 bg-gray-50 rounded-lg px-3 py-2">{{ $order->note }}</dd></div>
                @endif
            </dl>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-gray-100 font-semibold text-gray-900">অর্ডার আইটেম</div>
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="flex items-center gap-4 px-5 py-3">
                <img src="{{ $item['image'] }}" alt="{{ $item['product_name'] }}" class="w-14 h-14 rounded-xl object-cover bg-gray-100 shrink-0">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm text-gray-900 line-clamp-1">{{ $item['product_name'] }}</p>
                    <p class="text-xs text-gray-400">{{ $item['size'] }} | {{ $item['color'] ?? '—' }} | × {{ $item['qty'] }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="font-bold text-sm text-gray-900">৳{{ number_format($item['line_total'], 0) }}</p>
                    <p class="text-xs text-gray-400">৳{{ number_format($item['unit_price'], 0) }} প্রতিটি</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="border-t border-gray-100 px-5 py-4 space-y-1 text-sm">
            <div class="flex justify-between text-gray-600"><span>সাবটোটাল</span><span>৳{{ number_format($order->subtotal, 0) }}</span></div>
            <div class="flex justify-between text-gray-600"><span>ডেলিভারি</span><span>৳{{ number_format($order->delivery_charge, 0) }}</span></div>
            <div class="flex justify-between font-bold text-gray-900 text-base pt-1 border-t border-gray-100 mt-1"><span>মোট</span><span>৳{{ number_format($order->total, 0) }}</span></div>
        </div>
    </div>

    {{-- Status Update --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
        <h3 class="font-semibold text-gray-900 mb-4">স্ট্যাটাস আপডেট করুন</h3>
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center gap-3">
            @csrf @method('PATCH')
            <select name="status" class="flex-1 border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                @foreach(\App\Models\Order::STATUS_LABELS as $value => $label)
                    <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors">আপডেট করুন</button>
        </form>
    </div>
</div>
@endsection
