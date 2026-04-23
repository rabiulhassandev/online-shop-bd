@extends('layouts.app')

@section('title', 'হোম')
@section('meta_description', 'কাতুয়া শার্ট — বাংলাদেশের প্রিমিয়াম শার্ট ব্র্যান্ড। নতুন কালেকশন, বিশেষ ছাড়, দ্রুত ডেলিভারি।')

@section('content')

    {{-- Hero Slider --}}
    @if($sliders->count())
        <section x-data="{
                    current: 0,
                    total: {{ $sliders->count() }},
                    timer: null,
                    init() { this.timer = setInterval(() => this.next(), 5000); },
                    next() { this.current = (this.current + 1) % this.total; },
                    prev() { this.current = (this.current - 1 + this.total) % this.total; },
                    go(i) { this.current = i; clearInterval(this.timer); this.timer = setInterval(() => this.next(), 5000); }
                }" class="relative overflow-hidden bg-gray-900" style="height: 420px;">


            @foreach($sliders as $index => $slider)
                <div x-show="current === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute inset-0" style="display: none;">

                    <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                    <div class="absolute inset-0 flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                            <div class="max-w-xl">
                                @if($slider->title)
                                    <h1 class="text-3xl sm:text-5xl font-bold text-white leading-tight mb-4">
                                        {{ $slider->title }}
                                    </h1>
                                @endif
                                @if($slider->subtitle)
                                    <p class="text-lg text-gray-200 mb-8">{{ $slider->subtitle }}</p>
                                @endif
                                @if($slider->button_text && $slider->button_link)
                                    <a href="{{ $slider->button_link }}"
                                        class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-semibold px-8 py-3 rounded-full transition-colors duration-200 text-lg shadow-lg">
                                        {{ $slider->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Controls --}}
            <button @click="prev()"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white transition-colors backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white transition-colors backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Dots --}}
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
                @foreach($sliders as $i => $s)
                    <button @click="go({{ $i }})" :class="current === {{ $i }} ? 'bg-amber-400 w-6' : 'bg-white/50 w-2.5'"
                        class="h-2.5 rounded-full transition-all duration-300"></button>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Featured Products --}}
    @if($featuredProducts->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-1">বিশেষ পিক</p>
                    <h2 class="text-3xl font-bold text-gray-900">ফিচার্ড পণ্য</h2>
                </div>
                <a href="{{ route('products.index') }}"
                    class="text-sm font-medium text-gray-500 hover:text-amber-500 transition-colors hidden sm:block">সব দেখুন
                    →</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="text-center mt-8 sm:hidden">
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-amber-500">সব পণ্য দেখুন →</a>
            </div>
        </section>
    @endif

    {{-- New Arrivals --}}
    @if($newArrivals->count())
        <section class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-1">সাম্প্রতিক</p>
                        <h2 class="text-3xl font-bold text-gray-900">নতুন আগমন</h2>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="text-sm font-medium text-gray-500 hover:text-amber-500 transition-colors hidden sm:block">সব
                        দেখুন →</a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($newArrivals as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials --}}
    @if($testimonials->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-10">
                <p class="text-amber-500 text-sm font-semibold uppercase tracking-widest mb-1">গ্রাহকরা বলছেন</p>
                <h2 class="text-3xl font-bold text-gray-900">কাস্টমার রিভিউ</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonials as $review)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        {{-- Stars --}}
                        <div class="flex gap-0.5 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-700 text-sm leading-relaxed mb-4">"{{ $review->comment }}"</p>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-900 text-sm">{{ $review->reviewer_name }}</span>
                            @if($review->product)
                                <a href="{{ route('products.show', $review->product) }}"
                                    class="text-xs text-amber-500 hover:underline">{{ Str::limit($review->product->name, 20) }}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA / Contact Section --}}
    <section class="bg-gray-900 py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-3">অর্ডার করুন এখনই</h2>
            <p class="text-gray-400 mb-8">যেকোনো প্রশ্ন বা অর্ডারের জন্য আমাদের সাথে যোগাযোগ করুন</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="tel:{{ $phone }}"
                    class="flex items-center gap-2 bg-white text-gray-900 font-semibold px-6 py-3 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Call Now
                </a>
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank"
                    class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    WhatsApp
                </a>
                <a href="{{ $facebook }}" target="_blank"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    Facebook
                </a>
                @if(\App\Models\Setting::get('instagram_url'))
                <a href="{{ \App\Models\Setting::get('instagram_url') }}" target="_blank"
                style="
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 12px 24px;
                    border-radius: 9999px;
                    color: white;
                    font-weight: 600;
                    text-decoration: none;
                    background: linear-gradient(45deg, #833AB4, #FD1D1D, #FCAF45);
                "
                onmouseover="this.style.opacity='0.9'"
                onmouseout="this.style.opacity='1'">

                    <svg class="w-4 h-4 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.204-.012 3.584-.07 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.015-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.322a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/></svg>

                    Instagram
                </a>
                @endif
            </div>
        </div>
    </section>

@endsection