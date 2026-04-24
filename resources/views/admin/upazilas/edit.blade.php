@extends('layouts.admin')
@section('title', 'উপজেলা সম্পাদনা — '.$upazila->bn_name)
@section('page-title', 'উপজেলা সম্পাদনা')

@section('content')
<div class="max-w-2xl" x-data="{
    divisions: {{ json_encode($divisions) }},
    districts: [],
    selectedDivision: null,
    selectedDistrict: {{ $upazila->district_id ?? 'null' }
}" x-init="init()">
    <a href="{{ route('admin.upazilas.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-amber-500 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        উপজেলা তালিকায় ফিরুন
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
                            @change="loadDistricts($event.target.value)"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                        <option value="">বিভাগ নির্বাচন করুন</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" :selected="$upazila->district?->division_id == $division->id">
                                {{ $division->bn_name }} ({{ $division->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="district_select" class="block text-sm font-medium text-gray-700 mb-1">জেলা *</label>
                    <select id="district_select" name="district_id" required
                            :disabled="districts.length === 0"
                            class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 disabled:bg-gray-100">
                        <option value="">জেলা নির্বাচন করুন</option>
                        <template x-for="district in districts" :key="district.id">
                            <option :value="district.id" :selected="selectedDistrict == district.id">
                                {{ district.bn_name }} ({{ district.name }})
                            </option>
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

    <script>
        function init() {
            @if($upazila->district)
                selectedDivision = {{ $upazila->district->division_id }};
                loadDistricts(selectedDivision);
            @endif
        }

        function loadDistricts(divisionId) {
            if (!divisionId) {
                districts = [];
                return;
            }

            fetch(`{{ route('admin.api.districts.by-division', ':id') }}`.replace(':id', divisionId))
                .then(response => response.json())
                .then(data => {
                    districts = data;
                })
                .catch(error => console.error('Error loading districts:', error));
        }
    </script>
</div>
@endsection
