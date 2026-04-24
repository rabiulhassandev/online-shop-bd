<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'কাতুয়া শার্ট — বাংলাদেশের সেরা প্রিমিয়াম শার্ট ব্র্যান্ড। সেরা মানের শার্ট সাশ্রয়ী মূল্যে।')">
    <title>@yield('title', 'কাতুয়া শার্ট') | প্রিমিয়াম শার্ট ব্র্যান্ড</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- Icon --}}
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-white text-gray-900 antialiased">

{{-- Header --}}
<header class="bg-gray-900 border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Row 1: Search --}}
        <div class="py-2 border-b border-gray-100">
            <form action="{{ route('products.index') }}" method="GET" class="relative mx-auto w-full max-w-2xl">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="পণ্য খুঁজুন..."
                    class="bg-white w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm text-gray-700 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500"
                >
                <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-amber-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        {{-- Row 2: Logo, Links, Cart --}}
        <nav class="py-1">
            <div class="flex items-center justify-between gap-4">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2">
                    @if(\App\Models\Setting::get('site_logo') != 0)
                        <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="কাতুয়া শার্ট" class="h-12">
                    @else
                        <div>
                            <div class="text-2xl font-bold tracking-tight text-white">কাতুয়া <span class="text-amber-500">শার্ট</span></div>
                            <div class="text-xs text-white">প্রিমিয়াম শার্ট ব্র্যান্ড</div>
                        </div>
                    @endif
                </a>

                {{-- Desktop Navigation Links --}}
                <div class="hidden lg:flex items-center gap-8 relative z-50">
                    <a href="{{ route('home') }}" class="border-b-2 pb-1  text-md transition-colors {{ request()->routeIs('home') ? 'border-amber-500 text-white' : 'border-transparent text-white hover:text-amber-500' }}">হোম</a>
                    <a href="{{ route('about') }}" class="border-b-2 pb-1 text-md transition-colors {{ request()->routeIs('about') ? 'border-amber-500 text-amber-500' : 'border-transparent text-white hover:text-amber-500' }}">আমাদের সম্পর্কে</a>
                    
                    {{-- Products Dropdown --}}
                    <div class="relative group py-4 -my-4">
                        <a href="{{ route('products.index') }}" class="border-b-2 pb-1 text-md transition-colors flex items-center gap-1 {{ request()->routeIs('products.*') ? 'border-amber-500 text-amber-500' : 'border-transparent text-white hover:text-amber-500 group-hover:border-amber-500 group-hover:text-amber-500' }}">
                            সব পণ্য <i class='bx bx-chevron-down mt-1 transition-transform group-hover:rotate-180'></i>
                        </a>
                        
                        {{-- Dropdown Menu Container --}}
                        <div class="absolute left-0 top-full pt-4 w-64 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-1 group-hover:translate-y-0 z-50">
                            
                            {{-- Dropdown Card --}}
                            <div class="relative rounded-lg bg-white shadow-xl ring-1 ring-gray-900/5">
                                {{-- Top Pointer --}}
                                <div class="absolute -top-2 left-6 w-4 h-4 bg-white border-l border-t border-gray-900/5 rotate-45"></div>

                                @php
                                    $categories = \App\Models\Category::whereNull('parent_id')->where('is_active', true)->with(['children' => function($q) {
                                        $q->where('is_active', true)->orderBy('sort_order');
                                    }])->orderBy('sort_order')->get();
                                @endphp
                                
                                <div class="p-2 relative bg-white rounded-lg">
                                    @forelse($categories as $category)
                                        <div class="relative group/sub">
                                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="px-4 py-2.5 text-[15px] font-medium text-gray-700 rounded-md hover:bg-gray-50 hover:text-amber-600 transition-colors {{ $category->children->count() > 0 ? 'flex justify-between items-center' : 'block' }}">
                                                {{ $category->name }}
                                                @if($category->children->count() > 0)
                                                    <i class='bx bx-chevron-right text-gray-400 group-hover/sub:text-amber-500 transition-transform group-hover/sub:translate-x-1'></i>
                                                @endif
                                            </a>
                                            
                                            {{-- Subcategories Container --}}
                                            @if($category->children->count() > 0)
                                            <div class="absolute left-full top-0 pl-1 w-56 opacity-0 invisible group-hover/sub:opacity-100 group-hover/sub:visible transition-all duration-200 transform -translate-x-1 group-hover/sub:translate-x-0 z-50">
                                                <div class="rounded-lg bg-white shadow-xl ring-1 ring-gray-900/5 p-2">
                                                    @foreach($category->children as $child)
                                                        <a href="{{ route('products.index', ['category' => $child->slug]) }}" class="block px-4 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-50 hover:text-amber-600 transition-colors">
                                                            {{ $child->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="px-4 py-4 text-sm text-gray-500 text-center">কোনো ক্যাটাগরি নেই</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('reviews.index') }}" class="border-b-2 pb-1 text-md transition-colors {{ request()->routeIs('reviews.*') ? 'border-amber-500 text-amber-500' : 'border-transparent text-white hover:text-amber-500' }}">রিভিউ</a>
                    <a href="{{ route('home') }}#contact" class="border-b-2 border-transparent pb-1 text-md text-white transition-colors hover:text-amber-500">যোগাযোগ</a>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Cart icon --}}
                    <a href="{{ route('cart.index') }}" class="relative group">
                        <div class=" text-white hover:text-amber-500 rounded-lg p-2 transition-colors hover:bg-gray-100">
                            <i class="bx bx-cart ring-white mb-0" style="font-size: 25px;"></i>
                        </div>
                        @php $cartCount = app(\App\Services\CartService::class)->count(); @endphp
                        @if($cartCount > 0)
                            <span id="cart-count-badge" class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-white text-xs font-bold text-white">{{ $cartCount }}</span>
                        @else
                            <span id="cart-count-badge" class="hidden absolute -right-1 -top-1 h-5 w-5 items-center justify-center rounded-full bg-white text-xs font-bold text-white"></span>
                        @endif
                    </a>

                    {{-- Mobile menu button --}}
                    <button id="mobile-menu-btn" class="rounded-md p-2 hover:bg-white text-white hover:text-amber-500 lg:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden border-t border-gray-100 bg-gray-900 py-4 lg:hidden">
        <div class="max-w-7xl mx-auto space-y-1 px-4 sm:px-6">
            <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-md text-white hover:text-amber-500 hover:bg-white">হোম</a>
            <a href="{{ route('about') }}" class="block rounded-md px-3 py-2 text-md text-white hover:text-amber-500 hover:bg-white">আমাদের সম্পর্কে</a>
            
            {{-- Mobile Products --}}
            <div x-data="{ open: false }">
                <div class="flex items-center justify-between">
                    <a href="{{ route('products.index') }}" class="block flex-1 rounded-md px-3 py-2 text-md text-white hover:text-amber-500 hover:bg-white">সব পণ্য</a>
                    <button @click="open = !open" class="p-2 text-gray-300 hover:text-white">
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                
                <div x-show="open" class="pl-4 pr-2 py-1 space-y-1 border-l border-gray-700 ml-2 mt-1">
                    @php
                        if (!isset($categories)) {
                            $categories = \App\Models\Category::whereNull('parent_id')->where('is_active', true)->with(['children' => function($q) {
                                $q->where('is_active', true)->orderBy('sort_order');
                            }])->orderBy('sort_order')->get();
                        }
                    @endphp
                    @forelse($categories as $category)
                        <div x-data="{ subOpen: false }">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block flex-1 rounded-md px-3 py-2 text-sm text-gray-300 hover:text-white hover:bg-gray-800">
                                    {{ $category->name }}
                                </a>
                                @if($category->children->count() > 0)
                                    <button @click="subOpen = !subOpen" class="p-2 text-gray-400 hover:text-white">
                                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': subOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                @endif
                            </div>
                            
                            @if($category->children->count() > 0)
                                <div x-show="subOpen" class="pl-4 py-1 space-y-1 border-l border-gray-700 ml-2 mt-1 mb-1">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('products.index', ['category' => $child->slug]) }}" class="block rounded-md px-3 py-1.5 text-sm text-gray-400 hover:text-white hover:bg-gray-800">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="px-3 py-2 text-sm text-gray-500">কোনো ক্যাটাগরি নেই</div>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('reviews.index') }}" class="block rounded-md px-3 py-2 text-md text-white hover:text-amber-500 hover:bg-white">রিভিউ</a>
            <a href="{{ route('home') }}#contact" class="block rounded-md px-3 py-2 text-md text-white hover:text-amber-500 hover:bg-white">যোগাযোগ</a>
        </div>
    </div>
</header>

{{-- Flash Messages --}}
@if(session('success') || session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 flash-message">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>
@endif

{{-- Page Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            {{-- Brand --}}
            <div>
                @if(\App\Models\Setting::get('site_logo') != 0)
                    <img src="{{ asset('storage/' . \App\Models\Setting::get('site_logo')) }}" alt="কাতুয়া শার্ট" class="h-12">
                @else
                <h3 class="text-white text-xl font-bold mb-3">কাতুয়া <span class="text-amber-400">শার্ট</span></h3>
                @endif
                <p class="text-sm text-gray-400 leading-relaxed space-y-2">Your Style, Your Signature</p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold mb-3 text-sm uppercase tracking-wider">দ্রুত লিংক</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}"           class="hover:text-amber-400 transition-colors">হোম</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-amber-400 transition-colors">সব পণ্য</a></li>
                    <li><a href="{{ route('cart.index') }}"     class="hover:text-amber-400 transition-colors">কার্ট</a></li>
                    <li><a href="{{ route('terms') }}"          class="hover:text-amber-400 transition-colors">শর্তাবলী</a></li>
                    <li><a href="{{ route('return-policy') }}"  class="hover:text-amber-400 transition-colors">রিটার্ন পলিসি</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div id="contact">
                <h4 class="text-white font-semibold mb-3 text-sm uppercase tracking-wider">যোগাযোগ</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:{{ \App\Models\Setting::get('phone') }}" class="hover:text-amber-400 transition-colors">{{ \App\Models\Setting::get('phone', '01700000000') }}</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp', '8801700000000') }}" target="_blank" class="hover:text-amber-400 transition-colors">WhatsApp</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <a href="{{ \App\Models\Setting::get('facebook_url', '#') }}" target="_blank" class="hover:text-amber-400 transition-colors">Facebook</a>
                    </li>
                    @if(\App\Models\Setting::get('instagram_url'))
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.204-.012 3.584-.07 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.015-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.322a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/></svg>
                        <a href="{{ \App\Models\Setting::get('instagram_url', '#') }}" target="_blank" class="hover:text-amber-400 transition-colors">Instagram</a>
                    </li>
                    @endif
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="mailto:{{ \App\Models\Setting::get('email', 'info@example.com') }}" class="hover:text-white transition-colors">{{ \App\Models\Setting::get('email', 'info@example.com') }}</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ \App\Models\Setting::get('address', 'ঢাকা, বাংলাদেশ') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-10 pt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Men's Signature | All rights reserved.
        </div>
    </div>
</footer>

{{-- WhatsApp Floating Action Button --}}
<a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp', '8801700000000') }}"
   target="_blank"
   id="whatsapp-fab"
   class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-110"
   aria-label="WhatsApp এ যোগাযোগ করুন">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Auto-hide flash messages
    setTimeout(function() {
        document.querySelectorAll('.flash-message').forEach(function(el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(function() { el.remove(); }, 500);
        });
    }, 4000);

    // Countdown timer
    function initCountdowns() {
        document.querySelectorAll('[data-countdown]').forEach(function(el) {
            var end = parseInt(el.getAttribute('data-countdown'), 10);
            function tick() {
                var now = Math.floor(Date.now() / 1000);
                var diff = end - now;
                if (diff <= 0) {
                    el.innerHTML = '<span class="countdown-expired">মেয়াদ শেষ</span>';
                    el.closest('[data-discount-badge]')?.classList.add('hidden');
                    return;
                }
                var d = Math.floor(diff / 86400);
                var h = Math.floor((diff % 86400) / 3600);
                var m = Math.floor((diff % 3600) / 60);
                var s = diff % 60;
                var parts = [];
                if (d > 0) parts.push(d + 'দ');
                parts.push(String(h).padStart(2,'0') + 'ঘ');
                parts.push(String(m).padStart(2,'0') + 'মি');
                parts.push(String(s).padStart(2,'0') + 'সে');
                el.textContent = parts.join(' ');
            }
            tick();
            setInterval(tick, 1000);
        });
    }
    document.addEventListener('DOMContentLoaded', initCountdowns);
</script>

@stack('scripts')
</body>
</html>
