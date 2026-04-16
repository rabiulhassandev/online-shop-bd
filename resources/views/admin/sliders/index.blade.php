@extends('layouts.admin')
@section('title', 'স্লাইডার ব্যবস্থাপনা')
@section('page-title', 'স্লাইডার ব্যবস্থাপনা')

@section('content')
<div class="flex justify-end mb-5">
    <a href="{{ route('admin.sliders.create') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2 rounded-xl text-sm flex items-center gap-2 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        নতুন স্লাইডার
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">ছবি</th>
                    <th class="text-left px-4 py-3 text-xs font-medium text-gray-500">শিরোনাম</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">ক্রম</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">সক্রিয়</th>
                    <th class="text-center px-4 py-3 text-xs font-medium text-gray-500">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($sliders as $slider)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="w-24 h-14 object-cover rounded-xl bg-gray-100">
                    </td>
                    <td class="px-4 py-3">
                        <p class="font-medium text-gray-900">{{ $slider->title ?? '—' }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($slider->subtitle, 50) }}</p>
                    </td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $slider->sort_order }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="w-5 h-5 inline-block rounded-full {{ $slider->is_active ? 'bg-green-400' : 'bg-gray-200' }}"></span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-xs bg-gray-100 hover:bg-amber-100 hover:text-amber-700 px-3 py-1 rounded-lg transition-colors font-medium">সম্পাদনা</a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('মুছে ফেলবেন?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-lg transition-colors font-medium">মুছুন</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-10 text-gray-400">কোনো স্লাইডার নেই।</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-4 py-4 border-t border-gray-100">{{ $sliders->links() }}</div>
</div>
@endsection
