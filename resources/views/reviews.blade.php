@extends('layouts.app')

@section('title', 'গ্রাহক রিভিউ')
@section('meta_description', 'আমাদের গ্রাহকদের সৎ মতামত এবং রিভিউ পড়ুন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-8 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-amber-500">হোম</a>
        <span>/</span>
        <span class="text-gray-900">গ্রাহক রিভিউ</span>
    </nav>

    {{-- Page Title --}}
    <div class="mb-12">
        <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">গ্রাহক রিভিউ</h1>
        <div class="w-16 h-1 bg-amber-500 rounded-full"></div>
    </div>

    {{-- Reviews Grid --}}
    @if($reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($reviews as $review)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-6 flex flex-col">
                    {{-- Rating Stars --}}
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5 text-amber-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm font-semibold text-gray-700">{{ $review->rating }}.0</span>
                    </div>

                    {{-- Reviewer Name --}}
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $review->reviewer_name }}</h3>

                    {{-- Product Link --}}
                    @if($review->product)
                        <a href="{{ route('products.show', $review->product->slug) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium mb-3 inline-flex items-center gap-1">
                            {{ $review->product->name }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Comment --}}
                    <p class="text-gray-700 leading-relaxed mb-4 flex-grow">{{ $review->comment }}</p>

                    {{-- Date --}}
                    <div class="text-xs text-gray-500 pt-4 border-t border-gray-100">
                        {{ $review->created_at->format('d মাস Y') }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($reviews->hasPages())
            <div class="flex justify-center items-center gap-2 mb-10">
                {{-- Previous Page Link --}}
                @if($reviews->onFirstPage())
                    <span class="px-4 py-2 text-gray-400 cursor-not-allowed rounded-lg border border-gray-200">
                        পূর্ববর্তী
                    </span>
                @else
                    <a href="{{ $reviews->previousPageUrl() }}" class="px-4 py-2 text-amber-600 hover:bg-amber-50 rounded-lg border border-amber-200 transition-colors">
                        পূর্ববর্তী
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                    @if($page == $reviews->currentPage())
                        <span class="px-4 py-2 font-bold text-white bg-amber-500 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($reviews->hasMorePages())
                    <a href="{{ $reviews->nextPageUrl() }}" class="px-4 py-2 text-amber-600 hover:bg-amber-50 rounded-lg border border-amber-200 transition-colors">
                        পরবর্তী
                    </a>
                @else
                    <span class="px-4 py-2 text-gray-400 cursor-not-allowed rounded-lg border border-gray-200">
                        পরবর্তী
                    </span>
                @endif
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">কোনো রিভিউ নেই</h3>
            <p class="text-gray-600 mb-6">এই মুহূর্তে কোনো অনুমোদিত রিভিউ নেই। আপনার পছন্দের পণ্যে একটি রিভিউ লিখুন।</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors">
                পণ্য দেখুন
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endif

    {{-- CTA Section --}}
    <div class="mt-16 rounded-2xl p-10 text-white text-center py-10" style="background: linear-gradient(to right, #f59e0b, #d97706);">
        <h2 class="text-3xl font-bold mb-4">আপনার মতামত শেয়ার করুন</h2>
        <p class="text-amber-50 mb-6 text-lg">আপনি যে পণ্যগুলি ব্যবহার করেছেন সেগুলির জন্য একটি রিভিউ লিখুন এবং অন্য গ্রাহকদের সাহায্য করুন।</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-amber-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
            পণ্য ব্রাউজ করুন
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

</div>
@endsection
