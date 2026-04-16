@extends('layouts.admin')
@section('title', 'অর্ডার ব্যবস্থাপনা')
@section('page-title', 'অর্ডার ব্যবস্থাপনা')

@section('content')
{{-- Filter Tabs --}}
<div class="flex items-center gap-2 mb-5 flex-wrap">
    @foreach(['' => 'সব', 'pending' => 'পেন্ডিং', 'confirmed' => 'কনফার্ম', 'shipped' => 'শিপড', 'delivered' => 'ডেলিভার্ড', 'cancelled' => 'বাতিল'] as $status => $label)
    <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $status])) }}"
       class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors
              {{ request('status', '') === $status ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-gray-900' }}">
        {{ $label }} @if(isset($statusCounts[$status])) ({{ $statusCounts[$status] }}) @endif
    </a>
    @endforeach
</div>

{{-- Search + Export --}}
<div class="flex items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-2 flex-1">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="অর্ডার # বা ফোন নম্বর..."
               class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 w-64">
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-700 transition-colors">খুঁজুন</button>
    </form>
    <a href="{{ route('admin.orders.export', request()->query()) }}"
       class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        CSV Export
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">অর্ডার #</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">নাম / ফোন</th>
                    <th class="text-right px-4 py-3 text-xs font-medium text-gray-500">মোট</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">পেমেন্ট</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">স্ট্যাটাস</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">তারিখ</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                @php $color = \App\Models\Order::STATUS_COLORS[$order->status] ?? 'gray'; @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-mono text-xs text-amber-600">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->phone }}</p>
                    </td>
                    <td class="px-4 py-3 text-right font-semibold text-gray-900">৳{{ number_format($order->total, 0) }}</td>
                    <td class="px-4 py-3 text-center uppercase text-xs font-medium text-gray-600">{{ $order->payment_method }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-{{ $color }}-100 text-{{ $color }}-700">
                            {{ \App\Models\Order::STATUS_LABELS[$order->status] }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-xs text-gray-500">{{ $order->created_at->format('d M, H:i') }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="bg-gray-100 hover:bg-amber-100 hover:text-amber-700 text-xs font-medium px-3 py-1 rounded-lg transition-colors">বিস্তারিত</a>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-10 text-gray-400">কোনো অর্ডার নেই।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
</div>
@endsection
