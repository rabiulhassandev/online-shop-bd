@extends('layouts.admin')
@section('title', 'পণ্য ব্যবস্থাপনা')
@section('page-title', 'পণ্য ব্যবস্থাপনা')

@section('content')
<div class="flex items-center justify-between mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="পণ্য খুঁজুন..."
               class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 w-64">
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-700 transition-colors">খুঁজুন</button>
        @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">রিসেট</a>
        @endif
    </form>
    <a href="{{ route('admin.products.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2 rounded-xl text-sm transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        নতুন পণ্য
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">পণ্য</th>
                    <th class="text-right px-4 py-3 text-xs font-medium text-gray-500">দাম</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">স্টক</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">ফিচার্ড</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">সক্রিয়</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}"
                                 class="w-12 h-12 rounded-xl object-cover bg-gray-100 shrink-0">
                            <div>
                                <p class="font-medium text-gray-900 line-clamp-1">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <p class="font-semibold text-gray-900">৳{{ number_format($product->price, 0) }}</p>
                        @if($product->discounted_price)
                            <p class="text-xs text-green-600">৳{{ number_format($product->discounted_price, 0) }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="{{ $product->total_stock < 5 ? 'text-red-600 font-bold' : 'text-gray-800' }}">{{ $product->total_stock }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="w-5 h-5 inline-block rounded-full {{ $product->is_featured ? 'bg-green-400' : 'bg-gray-200' }}"></span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="w-5 h-5 inline-block rounded-full {{ $product->is_active ? 'bg-green-400' : 'bg-gray-200' }}"></span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-xs bg-gray-100 hover:bg-amber-100 hover:text-amber-700 px-3 py-1 rounded-lg transition-colors font-medium">সম্পাদনা</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('এই পণ্য মুছে ফেলবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-lg transition-colors font-medium">মুছুন</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-10 text-gray-400">কোনো পণ্য নেই।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
</div>
@endsection
