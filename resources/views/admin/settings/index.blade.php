@extends('layouts.admin')
@section('title', 'সাইট সেটিংস')
@section('page-title', 'সাইট সেটিংস')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
<style>
.ql-container { font-size: 14px; font-family: Inter, sans-serif; }
.ql-editor { min-height: 250px; padding: 12px; }
</style>
@endpush

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
        @csrf
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-5">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
        @endif

        {{-- Site Identity --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
            <h3 class="font-semibold text-gray-900 mb-4">সাইট পরিচিতি</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">সাইটের নাম</label>
                    <input type="text" name="site_name" value="{{ $settings->get('site_name', 'কাতুয়া শার্ট') }}"
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">লোগো</label>
                        @if($settings->get('site_logo'))
                            <img src="{{ asset('storage/'.$settings->get('site_logo')) }}" class="h-10 mb-2 rounded">
                        @endif
                        <input type="file" name="site_logo" accept="image/*" class="w-full text-sm border border-gray-300 rounded-xl px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ফেভিকন</label>
                        @if($settings->get('site_favicon'))
                            <img src="{{ asset('storage/'.$settings->get('site_favicon')) }}" class="h-8 mb-2">
                        @endif
                        <input type="file" name="site_favicon" accept="image/*" class="w-full text-sm border border-gray-300 rounded-xl px-3 py-2">
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
            <h3 class="font-semibold text-gray-900 mb-4">যোগাযোগ তথ্য</h3>
            <div class="space-y-4">
                @foreach([['key' => 'phone', 'label' => 'ফোন নম্বর', 'type' => 'text'], ['key' => 'email', 'label' => 'ইমেইল', 'type' => 'email'], ['key' => 'whatsapp', 'label' => 'WhatsApp নম্বর (কান্ট্রি কোড সহ)', 'type' => 'text'], ['key' => 'facebook_url', 'label' => 'Facebook URL', 'type' => 'url'], ['key' => 'instagram_url', 'label' => 'Instagram URL', 'type' => 'url']] as $field)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $field['label'] }}</label>
                    <input type="{{ $field['type'] }}" name="{{ $field['key'] }}" value="{{ $settings->get($field['key']) }}"
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                @endforeach
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ঠিকানা</label>
                    <textarea name="address" rows="2" class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 resize-none">{{ $settings->get('address') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Delivery & Payment --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5">
            <h3 class="font-semibold text-gray-900 mb-4">ডেলিভারি ও পেমেন্ট</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ডেলিভারি চার্জ (৳)</label>
                    <input type="number" name="delivery_charge" value="{{ $settings->get('delivery_charge', 80) }}" min="0"
                           class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700">পেমেন্ট পদ্ধতি সক্রিয় করুন</p>
                    @foreach([['key' => 'cod_enabled', 'label' => 'ক্যাশ অন ডেলিভারি (COD)'], ['key' => 'bkash_enabled', 'label' => 'বিকাশ (bKash)'], ['key' => 'nagad_enabled', 'label' => 'নগদ (Nagad)']] as $pm)
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50">
                        <input type="checkbox" name="{{ $pm['key'] }}" value="1" {{ $settings->get($pm['key']) === '1' ? 'checked' : '' }} class="accent-amber-500 w-4 h-4">
                        <span class="text-sm font-medium text-gray-700">{{ $pm['label'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- About Us --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-5" x-data="{}">
            <h3 class="font-semibold text-gray-900 mb-4">আমাদের সম্পর্কে</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">আমাদের সম্পর্কে বর্ণনা</label>
                <div id="about_us_editor" class="w-full border border-gray-300 rounded-xl bg-white h-64 text-sm focus-within:ring-2 focus-within:ring-amber-400"></div>
                <textarea name="about_us" class="hidden">{{ $settings->get('about_us') }}</textarea>
            </div>
        </div>

        {{-- Maintenance Mode --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">মেইনটেন্যান্স মোড</h3>
                    <p class="text-xs text-gray-500 mt-1">সক্রিয় করলে ফ্রন্টএন্ড দর্শনার্থীরা মেইনটেন্যান্স পেজ দেখবে।</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="maintenance_mode" value="1" {{ $settings->get('maintenance_mode') === '1' ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-amber-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                </label>
            </div>
        </div>

        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 rounded-xl transition-colors text-base shadow-md">
            সেটিংস সেভ করুন
        </button>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const aboutUsTextarea = document.querySelector('[name=about_us]');
  if (!aboutUsTextarea) {
    console.error('about_us textarea not found');
    return;
  }

  const aboutUsQuill = new Quill('#about_us_editor', {
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
    placeholder: 'আপনার ব্যবসার সম্পর্কে লিখুন...'
  });

  // Load existing content into Quill
  if (aboutUsTextarea.value) {
    aboutUsQuill.root.innerHTML = aboutUsTextarea.value;
  }

  // Sync to textarea before form submission
  const settingsForm = document.getElementById('settingsForm');
  if (settingsForm) {
    settingsForm.addEventListener('submit', function(e) {
      aboutUsTextarea.value = aboutUsQuill.root.innerHTML;
    });
  }
});
</script>
@endpush
@endsection
