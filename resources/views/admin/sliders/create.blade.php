@extends('layouts.admin')
@section('title', 'নতুন স্লাইডার')
@section('page-title', 'নতুন স্লাইডার যোগ করুন')

@section('content')
<div class="max-w-xl">
    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-4">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
        @endif
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ছবি * (সুপারিশ: 1920×600px)</label>
                <input type="file" name="image" accept="image/*" required class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">শিরোনাম</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">সাব-টাইটেল</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">বাটন টেক্সট</label>
                    <input type="text" name="button_text" value="{{ old('button_text') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">বাটন লিংক</label>
                    <input type="text" name="button_link" value="{{ old('button_link') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ক্রম</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_active" value="1" checked class="accent-amber-500 w-4 h-4" id="slider_active">
                    <label for="slider_active" class="text-sm font-medium text-gray-700">সক্রিয়</label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-sm transition-colors">সেভ করুন</button>
                <a href="{{ route('admin.sliders.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl text-sm transition-colors">বাতিল</a>
            </div>
        </div>
    </form>
</div>
@endsection
