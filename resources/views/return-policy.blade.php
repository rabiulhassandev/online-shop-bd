@extends('layouts.app')

@section('title', 'রিটার্ন পলিসি')
@section('meta_description', 'আমাদের রিটার্ন পলিসি পড়ুন')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-8 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-amber-500">হোম</a>
        <span>/</span>
        <span class="text-gray-900">রিটার্ন পলিসি</span>
    </nav>

    {{-- Page Title --}}
    <div class="mb-10">
        <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">রিটার্ন পলিসি</h1>
        <div class="w-16 h-1 bg-amber-500 rounded-full"></div>
    </div>

    {{-- Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <div class="prose prose-sm prose-a:text-amber-500 max-w-none text-gray-700 leading-relaxed">
                    {!! $content !!}
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
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
                        <a href="{{ route('terms') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            শর্তাবলী
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            আমাদের সম্পর্কে
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
