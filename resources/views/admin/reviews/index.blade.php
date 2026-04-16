@extends('layouts.admin')
@section('title', 'রিভিউ ব্যবস্থাপনা')
@section('page-title', 'রিভিউ ব্যবস্থাপনা')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">পণ্য</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">রিভিউয়ার</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">রেটিং</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">মন্তব্য</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">স্ট্যাটাস</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <a href="{{ $review->product ? route('products.show', $review->product) : '#' }}"
                           class="text-xs text-amber-600 hover:underline">
                            {{ $review->product?->name ?? '—' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $review->reviewer_name }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs max-w-xs">{{ Str::limit($review->comment, 80) }}</td>
                    <td class="px-4 py-3 text-center">
                        @php $colors = ['pending' => 'yellow', 'approved' => 'green', 'rejected' => 'red']; @endphp
                        <span class="inline-block text-xs font-semibold px-2.5 py-0.5 rounded-full bg-{{ $colors[$review->status] ?? 'gray' }}-100 text-{{ $colors[$review->status] ?? 'gray' }}-700">
                            {{ ucfirst($review->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1.5">
                            @if($review->status !== 'approved')
                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs bg-green-50 hover:bg-green-100 text-green-700 px-2.5 py-1 rounded-lg font-medium transition-colors">অনুমোদন</button>
                            </form>
                            @endif
                            @if($review->status !== 'rejected')
                            <form action="{{ route('admin.reviews.reject', $review) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-xs bg-orange-50 hover:bg-orange-100 text-orange-700 px-2.5 py-1 rounded-lg font-medium transition-colors">প্রত্যাখ্যান</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('মুছে ফেলবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-2.5 py-1 rounded-lg font-medium transition-colors">মুছুন</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-10 text-gray-400">কোনো রিভিউ নেই।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-4 border-t border-gray-100">{{ $reviews->links() }}</div>
</div>
@endsection
