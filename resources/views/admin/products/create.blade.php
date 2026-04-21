@extends('layouts.admin')
@section('title', 'নতুন পণ্য')
@section('page-title', 'নতুন পণ্য যোগ করুন')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
<style>
.ql-container { font-size: 14px; font-family: Inter, sans-serif; }
.ql-editor { min-height: 250px; padding: 12px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
<script>
const quill = new Quill('#product_description', {
  theme: 'snow',
  modules: {
    toolbar: [
      ['bold', 'italic', 'underline'],
      ['blockquote', 'code-block'],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      ['link'],
      ['clean']
    ]
  },
  placeholder: 'নিজের পণ্যের বিবরণ টাইপ করুন...'
});

document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', function() {
    document.querySelector('[name=description]').value = quill.root.innerHTML;
  });
});
</script>
@endpush

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" x-data="{
        sizes: [{ size: 'S', stock: 0 }, { size: 'M', stock: 0 }, { size: 'L', stock: 0 }, { size: 'XL', stock: 0 }, { size: 'XXL', stock: 0 }],
        colors: [],
        newColor: '',
        addColor() { if (this.newColor.trim()) { this.colors.push(this.newColor.trim()); this.newColor = ''; } },
        removeColor(i) { this.colors.splice(i, 1); }
    }">
        @csrf
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-5">
                @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Info --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">মূল তথ্য</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">পণ্যের নাম *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">স্লাগ (খালি রাখলে স্বয়ংক্রিয়)</label>
                            <input type="text" name="slug" value="{{ old('slug') }}"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">বিবরণ</label>
                            <div id="product_description" class="w-full border border-gray-300 rounded-xl bg-white h-64 text-sm focus-within:ring-2 focus-within:ring-amber-400"></div>
                            <textarea name="description" class="hidden">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">মূল্য ও ডিসকাউন্ট</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">মূল দাম (৳) *</label>
                            <input type="number" name="price" value="{{ old('price') }}" required min="0" step="0.01"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ডিস্কাউন্ট দাম (৳)</label>
                            <input type="number" name="discounted_price" value="{{ old('discounted_price') }}" min="0" step="0.01"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ছাড় শুরু</label>
                            <input type="datetime-local" name="discount_start_at" value="{{ old('discount_start_at') }}"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ছাড় শেষ</label>
                            <input type="datetime-local" name="discount_end_at" value="{{ old('discount_end_at') }}"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        </div>
                    </div>
                </div>

                {{-- Sizes --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">সাইজ ও স্টক</h3>
                    <div class="space-y-3">
                        <template x-for="(s, i) in sizes" :key="i">
                            <div class="flex items-center gap-3">
                                <span class="w-12 text-center font-medium text-sm bg-gray-100 rounded-lg py-2" x-text="s.size"></span>
                                <input type="hidden" :name="'sizes['+i+'][size]'" :value="s.size">
                                <div class="flex-1 flex items-center gap-2">
                                    <label class="text-xs text-gray-500">স্টক:</label>
                                    <input type="number" :name="'sizes['+i+'][stock]'" x-model="s.stock" min="0"
                                           class="w-24 border border-gray-300 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Colors --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">কালার ভ্যারিয়েন্ট</h3>
                    <div class="flex gap-2 mb-3">
                        <input type="text" x-model="newColor" @keydown.enter.prevent="addColor()"
                               placeholder="কালারের নাম লিখুন..."
                               class="flex-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <button type="button" @click="addColor()"
                                class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-700 transition-colors">যোগ করুন</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="(c, i) in colors" :key="i">
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 border border-amber-200 text-sm px-3 py-1 rounded-full">
                                <input type="hidden" :name="'colors[]'" :value="c">
                                <span x-text="c"></span>
                                <button type="button" @click="removeColor(i)" class="ml-1 hover:text-red-500">×</button>
                            </span>
                        </template>
                    </div>
                </div>

                {{-- Images --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">পণ্যের ছবি (সর্বোচ্চ ৫টি)</h3>
                    <input type="file" name="images[]" accept="image/*" multiple
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — সর্বোচ্চ 2MB প্রতিটি</p>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-semibold text-gray-900 mb-4">অবস্থা</h3>
                    <div class="space-y-3">
                        @foreach([['name' => 'is_active', 'label' => 'সক্রিয়', 'checked' => true], ['name' => 'is_featured', 'label' => 'ফিচার্ড', 'checked' => false], ['name' => 'is_new_arrival', 'label' => 'নতুন আগমন', 'checked' => false]] as $toggle)
                        <label class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">{{ $toggle['label'] }}</span>
                            <input type="checkbox" name="{{ $toggle['name'] }}" value="1" {{ old($toggle['name'], $toggle['checked'] ? '1' : '') ? 'checked' : '' }}
                                   class="w-4 h-4 accent-amber-500">
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                        পণ্য সেভ করুন
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition-colors text-sm">বাতিল</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
