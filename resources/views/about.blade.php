@extends('layouts.app')

@section('title', 'আমাদের সম্পর্কে')
@section('meta_description', 'আমাদের সম্পর্কে জানুন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-8 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-amber-500">হোম</a>
        <span>/</span>
        <span class="text-gray-900">আমাদের সম্পর্কে</span>
    </nav>

    {{-- Page Title --}}
    <div class="mb-10">
        <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">আমাদের সম্পর্কে</h1>
        <div class="w-16 h-1 bg-amber-500 rounded-full"></div>
    </div>

    {{-- About Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <div class="prose prose-sm prose-a:text-amber-500 max-w-none text-gray-700 leading-relaxed">
                    {!! $aboutUs !!}
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Info Card --}}
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl border border-amber-200 p-6 shadow-sm">
                <h3 class="font-semibold text-gray-900 mb-4">দ্রুত লিংক</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            আমাদের পণ্য দেখুন
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}#testimonials" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            পর্যালোচনা পড়ুন
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                <h3 class="font-semibold text-gray-900 mb-4">আমাদের সাথে যোগাযোগ করুন</h3>
                <div class="space-y-3 text-sm">
                    @php
                        $phone = \App\Models\Setting::get('phone');
                        $email = \App\Models\Setting::get('email');
                        $whatsapp = \App\Models\Setting::get('whatsapp');
                        $address = \App\Models\Setting::get('address');
                    @endphp

                    @if($phone)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948.684l1.498 4.493a1 1 0 00.502.609l2.01 1.042a1 1 0 001.09-.127l2.04-2.574a1 1 0 011.467.573l1.745 5.215a1 1 0 00.896.659h.108a1 1 0 001 .999l5 .002a2 2 0 012 2C21 13.35 13.591 21 11 21s-10-7.65-10-13a2 2 0 012-2z"/></svg>
                        <div>
                            <p class="text-gray-500">ফোন</p>
                            <a href="tel:{{ $phone }}" class="text-gray-900 font-semibold hover:text-amber-600">{{ $phone }}</a>
                        </div>
                    </div>
                    @endif

                    @if($email)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <div>
                            <p class="text-gray-500">ইমেইল</p>
                            <a href="mailto:{{ $email }}" class="text-gray-900 font-semibold hover:text-amber-600 break-all">{{ $email }}</a>
                        </div>
                    </div>
                    @endif

                    @if($address)
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <p class="text-gray-500">ঠিকানা</p>
                            <p class="text-gray-900 font-semibold">{{ $address }}</p>
                        </div>
                    </div>
                    @endif

                    @if($whatsapp)
                    <div class="pt-2 border-t border-gray-200">
                        <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-9.746 9.798c0 2.734.75 5.404 2.177 7.697l-2.313 6.256 6.514-2.286c2.21 1.214 4.688 1.856 7.298 1.856 5.412 0 9.846-4.433 9.846-9.846 0-2.605-.505-5.094-1.49-7.432-1.026-2.572-2.831-4.846-5.034-6.409-2.23-1.579-4.842-2.42-7.604-2.236"/></svg>
                            WhatsApp এ যোগাযোগ করুন
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
