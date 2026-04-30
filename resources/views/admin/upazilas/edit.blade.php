@extends('layouts.admin')
@section('title', 'উপজেলা/থানা সম্পাদনা — '.$upazila->bn_name)
@section('page-title', 'উপজেলা/থানা সম্পাদনা')

@section('content')
<div class="max-w-2xl" x-data="{
    currentDistrict: @js($upazila->district?->only(['id', 'name', 'bn_name'])),
    districts: @js($upazila->district ? [$upazila->district->only(['id', 'name', 'bn_name'])] : []),
    selectedDivision: @js((string) old('division_id', $upazila->district?->division_id)),
    selectedDistrict: @js((string) old('district_id', $upazila->district_id)),
    loadDistricts(divisionId, preserveDistrict = false) {
        const selectedDistrict = this.selectedDistrict;

        if (!preserveDistrict) {
            this.selectedDistrict = '';
        }

        if (!divisionId) {
            this.districts = [];
            return;
        }

        fetch(`{{ route('admin.api.districts.by-division', ':id') }}`.replace(':id', divisionId))
            .then(response => response.json())
            .then(data => {
                if (
                    preserveDistrict &&
                    this.currentDistrict &&
                    !data.some(district => String(district.id) === String(selectedDistrict))
                ) {
                    data.unshift(this.currentDistrict);
                }

                this.districts = data;

                if (preserveDistrict) {
                    this.$nextTick(() => {
                        this.selectedDistrict = String(selectedDistrict);
                    });
                }
            })
            .catch(error => console.error('Error loading districts:', error));
    }
}" x-init="if (selectedDivision) loadDistricts(selectedDivision, true)">
    <a href="{{ route('admin.upazilas.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-amber-500 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        উপজেলা/থানা তালিকায় ফিরুন
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form action="{{ route('admin.upazilas.update', $upazila) }}" method="POST">
            @csrf @method('PATCH')

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-sm text-red-700 mb-4">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="division_select" class="block text-sm font-medium text-gray-700 mb-1">বিভাগ *</label>
                    <select id="division_select" name="division_id" required
                            x-model="selectedDivision"
                            @change="loadDistricts($event.target.value)"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">বিভাগ নির্বাচন করুন</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}">
                                {{ $division->bn_name }} ({{ $division->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="district_select" class="block text-sm font-medium text-gray-700 mb-1">জেলা *</label>
                    <select id="district_select" name="district_id" required
                            x-model="selectedDistrict"
                            :disabled="!selectedDivision || districts.length === 0"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 disabled:bg-gray-100">
                        <option value="">জেলা নির্বাচন করুন</option>
                        <template x-for="district in districts" :key="district.id">
                            <option
                                :value="String(district.id)"
                                :selected="String(district.id) === @js((string) $upazila->district_id)"
                                x-text="`${district.bn_name} (${district.name})`"
                            ></option>
                        </template>
                    </select>
                    <p x-show="selectedDivision && districts.length === 0" class="text-xs text-gray-400 mt-1">এই বিভাগে কোনো জেলা নেই</p>
                </div>

                <div>
                    <label for="bn_name" class="block text-sm font-medium text-gray-700 mb-1">নাম (বাংলা) *</label>
                    <input type="text" id="bn_name" name="bn_name" value="{{ old('bn_name', $upazila->bn_name) }}" required
                           class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                           placeholder="সাভার">
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">নাম (English) *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $upazila->name) }}" required
                           class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                           placeholder="Savar">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $upazila->is_active) ? 'checked' : '' }} class="accent-amber-500 w-4 h-4">
                    <label for="is_active" class="text-sm text-gray-700">সক্রিয়</label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2 rounded-xl text-sm transition-colors">
                        আপডেট করুন
                    </button>
                    <a href="{{ route('admin.upazilas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-5 py-2 rounded-xl text-sm transition-colors">
                        বাতিল
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
