@extends('layouts.admin')
@section('title', 'ড্যাশবোর্ড')
@section('page-title', 'ড্যাশবোর্ড')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['label' => 'মোট অর্ডার',    'value' => $totalOrders,            'color' => 'blue',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'মোট রাজস্ব (৳)', 'value' => '৳'.number_format($totalRevenue, 0), 'color' => 'green',  'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'পেন্ডিং অর্ডার', 'value' => $pendingOrders,          'color' => 'yellow', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'আজকের অর্ডার',  'value' => $todayOrders,            'color' => 'purple', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ] as $card)
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $card['label'] }}</p>
            <div class="w-9 h-9 rounded-xl bg-{{ $card['color'] }}-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-{{ $card['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Recent Orders --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-900">সাম্প্রতিক অর্ডার</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-amber-500 hover:underline">সব দেখুন</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">অর্ডার #</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">নাম</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">ফোন</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-gray-500">মোট</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">স্ট্যাটাস</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-mono text-xs text-amber-600 hover:underline">{{ $order->order_number }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-800">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $order->phone }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">৳{{ number_format($order->total, 0) }}</td>
                        <td class="px-4 py-3 text-center">
                            @php $color = \App\Models\Order::STATUS_COLORS[$order->status] ?? 'gray'; @endphp
                            <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-{{ $color }}-100 text-{{ $color }}-700">
                                {{ \App\Models\Order::STATUS_LABELS[$order->status] ?? $order->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($recentOrders->isEmpty())
                <p class="text-center text-sm text-gray-400 py-8">কোনো অর্ডার নেই।</p>
            @endif
        </div>
    </div>

    {{-- Low Stock Alerts --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <h3 class="font-semibold text-gray-900">কম স্টক</h3>
        </div>
        <div class="p-2">
            @forelse($lowStockProducts as $product)
            <a href="{{ route('admin.products.edit', $product) }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors group">
                <span class="text-sm text-gray-800 group-hover:text-amber-600 transition-colors line-clamp-1">{{ $product->name }}</span>
                <span class="ml-2 shrink-0 text-xs font-bold {{ $product->total_stock === 0 ? 'text-red-500' : 'text-orange-500' }}">
                    {{ $product->total_stock }} বাকি
                </span>
            </a>
            @empty
                <p class="text-center text-sm text-gray-400 py-6">সব পণ্যের স্টক ঠিক আছে ✓</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
