@extends('layouts.admin')
@section('title', 'নতুন ক্যাটেগরি')
@section('page-title', 'নতুন ক্যাটেগরি যোগ করুন')

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-5">
                @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ক্যাটেগরি নাম *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                @error('name')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">স্লাগ (খালি রাখলে স্বয়ংক্রিয়)</label>
                <input type="text" name="slug" value="{{ old('slug') }}"
                       class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                       placeholder="ক্যাটেগরি-নাম">
                @error('slug')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">বিবরণ</label>
                <textarea name="description"
                          class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 h-28"
                          placeholder="ক্যাটেগরির বিবরণ লিখুন...">{{ old('description') }}</textarea>
                @error('description')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">অভিভাবক ক্যাটেগরি (ঐচ্ছিক)</label>
                <select name="parent_id"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <option value="">-- কোনো নয় --</option>
                    @foreach($parentCategories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ক্রম সংখ্যা</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    @error('sort_order')<span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>@enderror
                </div>

                <div class="flex items-end">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="false">
                        <input type="checkbox" name="is_active" value="true" {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300">
                        <span class="text-sm font-medium text-gray-700">সক্রিয় করুন</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                ক্যাটেগরি যোগ করুন
            </button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-2.5 rounded-xl text-sm transition-colors">
                বাতিল
            </a>
        </div>
    </form>
</div>
@endsection
