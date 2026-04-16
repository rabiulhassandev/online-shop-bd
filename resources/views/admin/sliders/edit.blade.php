@extends('layouts.admin')
@section('title', 'স্লাইডার সম্পাদনা')
@section('page-title', 'স্লাইডার সম্পাদনা')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">বিদ্যমান ছবি</label>
                <img src="{{ $slider->image_url }}" class="w-full h-40 object-cover rounded-xl mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">নতুন ছবি (পরিবর্তন করতে চাইলে)</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">শিরোনাম</label>
                <input type="text" name="title" value="{{ old('title', $slider->title) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">সাব-টাইটেল</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">বাটন টেক্সট</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">বাটন লিংক</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $slider->button_link) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ক্রম</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" min="0" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} class="accent-amber-500 w-4 h-4" id="slider_active">
                    <label for="slider_active" class="text-sm font-medium text-gray-700">সক্রিয়</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-sm transition-colors">আপডেট করুন</button>
                <a href="{{ route('admin.sliders.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl text-sm transition-colors">বাতিল</a>
            </div>
        </div>
    </form>
</div>
@endsection
