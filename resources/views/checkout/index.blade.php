@extends('layouts.app')

@section('title', 'চেকআউট')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">চেকআউট</h1>

    <form action="{{ isset($product) ? route('checkout.store-order-now') : route('checkout.store') }}" method="POST">
        @csrf

        {{-- Hidden fields for Order Now --}}
        @isset($product)
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="size" value="{{ $size ?? '' }}">
            <input type="hidden" name="color" value="{{ $color ?? '' }}">
            <input type="hidden" name="qty" value="{{ $qty ?? 1 }}">
        @endisset

@php
    $insideDhaka = \App\Models\Setting::get('delivery_fee_inside_dhaka', 80);
    $subDhaka = \App\Models\Setting::get('delivery_fee_sub_dhaka', 100);
    $outsideDhaka = \App\Models\Setting::get('delivery_fee_outside_dhaka', 120);
    // If bulk items = free delivery
    $totalQty = array_sum(array_column($items, 'qty'));
    $isFreeDelivery = $totalQty > 1;
@endphp

        <div class="flex flex-col lg:flex-row gap-8" x-data="{
            districts: [],
            upazilas: [],
            selectedDivision: '{{ old('division_id') ?? '' }}',
            selectedDistrict: '{{ old('district_id') ?? '' }}',
            selectedUpazila: '{{ old('upazila_id') ?? '' }}',
            deliveryArea: 'inside_dhaka',
            deliveryFees: { 
                'inside_dhaka': {{ $insideDhaka }}, 
                'sub_dhaka': {{ $subDhaka }}, 
                'outside_dhaka': {{ $outsideDhaka }} 
            },
            isFreeDelivery: {{ $isFreeDelivery ? 'true' : 'false' }},
            subtotal: {{ $subtotal }},
            get deliveryCharge() {
                return this.isFreeDelivery ? 0 : this.deliveryFees[this.deliveryArea];
            },
            get total() {
                return this.subtotal + this.deliveryCharge;
            },
            loadDistricts(divisionId) {
                if (!divisionId) {
                    this.districts = [];
                    this.selectedDistrict = '';
                    this.upazilas = [];
                    this.selectedUpazila = '';
                    return;
                }
                fetch(`{{ route('api.districts.by-division', ':id') }}`.replace(':id', divisionId))
                    .then(response => response.json())
                    .then(data => {
                        this.districts = data;
                        this.upazilas = [];
                        this.selectedUpazila = '';
                    })
                    .catch(error => console.error('Error loading districts:', error));
            },
            loadUpazilas(districtId) {
                if (!districtId) {
                    this.upazilas = [];
                    this.selectedUpazila = '';
                    return;
                }
                fetch(`{{ route('api.upazilas.by-district', ':id') }}`.replace(':id', districtId))
                    .then(response => response.json())
                    .then(data => {
                        this.upazilas = data;
                    })
                    .catch(error => console.error('Error loading upazilas:', error));
            }
        }" x-init="$nextTick(() => { if(selectedDivision) loadDistricts(selectedDivision); if(selectedDistrict) loadUpazilas(selectedDistrict); })">

            {{-- Checkout Form --}}
            <div class="flex-1">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-6">
                    <h2 class="font-bold text-gray-900 text-lg mb-5">ডেলিভারি তথ্য</h2>

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-sm text-red-700 mb-4">
                            @foreach($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">পূর্ণ নাম *</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow"
                                   placeholder="আপনার পূর্ণ নাম লিখুন">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">ফোন নম্বর *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow"
                                   placeholder="01XXXXXXXXX">
                        </div>

                        
                        <div>
                            <label for="delivery_area" class="block text-sm font-medium text-gray-700 mb-1">ডেলিভারি এরিয়া *</label>
                            <select id="delivery_area" name="delivery_area" required
                                    x-model="deliveryArea"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow">
                                <option value="inside_dhaka">ঢাকার ভিতরে</option>
                                <option value="sub_dhaka">ঢাকা উপ-শাখা</option>
                                <option value="outside_dhaka">ঢাকার বাহিরে</option>
                            </select>
                        </div>

                        {{-- Division --}}
                        <div>
                            <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1">বিভাগ *</label>
                            <select id="division_id" name="division_id" required
                                    x-model="selectedDivision"
                                    @change="loadDistricts($event.target.value)"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow">
                                <option value="">বিভাগ নির্বাচন করুন</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->bn_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- District --}}
                        <div>
                            <label for="district_id" class="block text-sm font-medium text-gray-700 mb-1">জেলা *</label>
                            <select id="district_id" name="district_id" required
                                    x-model="selectedDistrict"
                                    :disabled="!selectedDivision || districts.length === 0"
                                    @change="loadUpazilas($event.target.value)"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow disabled:bg-gray-100">
                                <option value="">জেলা নির্বাচন করুন</option>
                                <template x-for="district in districts" :key="district.id">
                                    <option :value="district.id" x-text="district.bn_name"></option>
                                </template>
                            </select>
                            <p x-show="selectedDivision && districts.length === 0" class="text-xs text-gray-400 mt-1">এই বিভাগে কোনো জেলা নেই</p>
                        </div>

                        {{-- Upazila --}}
                        <div>
                            <label for="upazila_id" class="block text-sm font-medium text-gray-700 mb-1">উপজেলা *</label>
                            <select id="upazila_id" name="upazila_id" required
                                    x-model="selectedUpazila"
                                    :disabled="!selectedDistrict || upazilas.length === 0"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow disabled:bg-gray-100">
                                <option value="">উপজেলা নির্বাচন করুন</option>
                                <template x-for="upazila in upazilas" :key="upazila.id">
                                    <option :value="upazila.id" x-text="upazila.bn_name"></option>
                                </template>
                            </select>
                            <p x-show="selectedDistrict && upazilas.length === 0" class="text-xs text-gray-400 mt-1">এই জেলায় কোনো উপজেলা নেই</p>
                        </div>

                        {{-- Delivery Area --}}

                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">ডেলিভারি ঠিকানা *</label>
                            <textarea id="address" name="address" rows="3" required
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow resize-none"
                                      placeholder="বাড়ি নং, রোড, এলাকা, জেলা...">{{ old('address') }}</textarea>
                        </div>

                    </div>
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">অর্ডার নোট (ঐচ্ছিক)</label>
                        <textarea id="note" name="note" rows="2" maxlength="500"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 transition-shadow resize-none"
                                    placeholder="অন্য কোনো তথ্য থাকলে লিখুন...">{{ old('note') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">সর্বোচ্চ ৫০০ অক্ষর</p>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h2 class="font-bold text-gray-900 text-lg mb-5">পেমেন্ট পদ্ধতি</h2>

                    @if(!empty($paymentMethods))
                    <div class="space-y-3">
                        @foreach($paymentMethods as $value => $label)
                        <label class="flex items-center gap-3 p-4 rounded-xl border border-gray-200 cursor-pointer hover:border-amber-400 has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 transition-all">
                            <input type="radio" name="payment_method" value="{{ $value }}"
                                   {{ old('payment_method', array_key_first($paymentMethods)) === $value ? 'checked' : '' }}
                                   class="accent-amber-500 w-4 h-4">
                            <span class="font-medium text-sm text-gray-800">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                        <p class="text-sm text-red-500">কোনো পেমেন্ট পদ্ধতি সক্রিয় নেই।</p>
                    @endif
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-72 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-20">
                    <h2 class="font-bold text-gray-900 text-lg mb-5">অর্ডার সারসংক্ষেপ</h2>

                    <div class="space-y-3 mb-5">
                        @foreach($items as $item)
                        <div class="flex items-center gap-3">
                            <img src="{{ $item['product']->primary_image }}" alt="{{ $item['product']->name }}"
                                 class="w-12 h-12 rounded-xl object-cover bg-gray-50 shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-medium text-gray-800 line-clamp-1">{{ $item['product']->name }}</p>
                                <p class="text-xs text-gray-400">{{ $item['size'] }} × {{ $item['qty'] }}</p>
                            </div>
                            <p class="text-xs font-bold text-gray-900">৳{{ number_format($item['line_total'], 0) }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2 text-sm mb-5">
                        <div class="flex justify-between text-gray-600">
                            <span>সাবটোটাল</span><span>৳{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>ডেলিভারি</span>
                            <template x-if="isFreeDelivery">
                                <span class="text-green-600 font-medium">ফ্রি!</span>
                            </template>
                            <template x-if="!isFreeDelivery">
                                <span x-text="'৳' + Number(deliveryCharge).toLocaleString()"></span>
                            </template>
                        </div>
                        <template x-if="isFreeDelivery">
                            <p class="text-xs text-green-600 flex items-center gap-1">
                                <i class='bx bxs-gift text-sm'></i>
                                ১টির বেশি পণ্য কিনলে ফ্রি ডেলিভারি!
                            </p>
                        </template>
                        <div class="border-t border-gray-100 pt-2 flex justify-between font-bold text-gray-900 text-base">
                            <span>মোট</span><span x-text="'৳' + Number(total).toLocaleString()"></span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 rounded-xl transition-colors shadow-md hover:shadow-lg text-base">
                        ✓ অর্ডার নিশ্চিত করুন
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
