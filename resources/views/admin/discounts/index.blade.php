@extends('layouts.admin')
@section('title', 'ডিসকাউন্ট ব্যবস্থাপনা')
@section('page-title', 'ডিসকাউন্ট ব্যবস্থাপনা')

@section('content')

{{-- Bulk Discount --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-6">
    <h3 class="font-semibold text-gray-900 mb-4">বাল্ক ডিসকাউন্ট প্রয়োগ করুন</h3>
    <form action="{{ route('admin.discounts.bulk') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">ছাড় (%) *</label>
                <input type="number" name="discount_percent" min="1" max="99" placeholder="20"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">শুরু</label>
                <input type="datetime-local" name="discount_start_at"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">শেষ</label>
                <input type="datetime-local" name="discount_end_at"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 rounded-xl text-sm transition-colors">প্রয়োগ করুন</button>
            </div>
        </div>
        <p class="text-xs text-gray-400">নিচ থেকে পণ্য নির্বাচন করুন, তারপর আপডেট করুন।</p>
    </form>
</div>

{{-- Per-product table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left"><input type="checkbox" id="select-all" class="accent-amber-500 w-4 h-4" onchange="document.querySelectorAll('.product-cb').forEach(c=>c.checked=this.checked)"></th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">পণ্য</th>
                    <th class="text-right px-4 py-3 text-xs font-medium text-gray-500">মূল দাম</th>
                    <th class="text-right px-4 py-3 text-xs font-medium text-gray-500">ডিসকাউন্ট দাম</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">শেষ তারিখ</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">আপডেট</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" form="bulk-form" class="product-cb accent-amber-500 w-4 h-4">
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-right text-gray-700">৳{{ number_format($product->price, 0) }}</td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('admin.discounts.update', $product) }}" method="POST" class="inline-flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="discounted_price" value="{{ $product->discounted_price }}" min="0" step="0.01"
                                   class="w-24 border border-gray-300 rounded-lg px-2 py-1 text-sm text-right focus:outline-none focus:ring-2 focus:ring-amber-400">
                            <input type="hidden" name="discount_end_at" value="{{ $product->discount_end_at?->format('Y-m-d\TH:i') }}">
                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">সেভ</button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-center text-xs text-gray-500">
                        {{ $product->discount_end_at?->format('d M Y') ?? '—' }}
                    </td>
                    <td class="px-4 py-3 text-center text-xs text-gray-400">
                        @if($product->discounted_price)
                            <span class="text-green-600">{{ $product->discount_percent }}% ছাড়</span>
                        @endif
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-10 text-gray-400">কোনো পণ্য নেই।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-4 border-t border-gray-100">{{ $products->links() }}</div>
</div>
@endsection
