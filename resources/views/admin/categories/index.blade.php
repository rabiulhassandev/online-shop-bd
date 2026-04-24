@extends('layouts.admin')
@section('title', 'ক্যাটেগরি ব্যবস্থাপনা')
@section('page-title', 'ক্যাটেগরি ব্যবস্থাপনা')

@section('content')
<div class="flex items-center justify-between mb-6">
    <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="ক্যাটেগরি খুঁজুন..."
               class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 w-64">
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-700 transition-colors">খুঁজুন</button>
        @if(request('search'))
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-red-500 py-2">রিসেট</a>
        @endif
    </form>
    <a href="{{ route('admin.categories.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2 rounded-xl text-sm transition-colors flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        নতুন ক্যাটেগরি
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">নাম</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">Root ক্যাটেগরি</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">পণ্য</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">সক্রিয়</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">ক্রম</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition-colors {{ $category->parent_id ? 'bg-gray-50' : '' }}">
                    <td class="px-4 py-3">
                        <div {{ $category->parent_id ? 'class=pl-8' : '' }}>
                            <div class="flex items-center gap-2">
                                @if($category->parent_id)
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                @endif
                                <p class="font-medium {{ $category->parent_id ? 'text-gray-700' : 'text-gray-900' }}">{{ $category->name }}</p>
                            </div>
                            <p class="text-xs text-gray-400">{{ $category->slug }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-gray-700">{{ $category->parent?->name ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block {{ $category->parent_id ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }} px-2.5 py-1 rounded-lg text-xs font-medium">
                            {{ $category->products_count ?? 0 }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="w-5 h-5 inline-block rounded-full {{ $category->is_active ? 'bg-green-400' : 'bg-gray-200' }}"></span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="text-gray-700 font-medium">{{ $category->sort_order }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="text-xs bg-gray-100 hover:bg-amber-100 hover:text-amber-700 px-3 py-1 rounded-lg transition-colors font-medium">সম্পাদনা</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('এই ক্যাটেগরি মুছে ফেলবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-lg transition-colors font-medium">মুছুন</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-10 text-gray-400">কোনো ক্যাটেগরি নেই।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-4 border-t border-gray-100">
        {{ $categories->links() }}
    </div>
</div>
@endsection
