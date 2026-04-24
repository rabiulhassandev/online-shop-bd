<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UpazilaController extends Controller
{
    public function index(): View
    {
        $upazilas = Upazila::with(['district.division'])->latest()->get();

        return view('admin.upazilas.index', compact('upazilas'));
    }

    public function create(): View
    {
        $divisions = Division::active()->orderBy('name')->get();

        return view('admin.upazilas.create', compact('divisions'));
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'name' => ['required', 'string', 'max:100'],
            'bn_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Upazila::create([
            'district_id' => request('district_id'),
            'name' => request('name'),
            'bn_name' => request('bn_name'),
            'is_active' => request()->boolean('is_active', true),
        ]);

        return redirect()->route('admin.upazilas.index')->with('success', 'উপজেলা তৈরি হয়েছে।');
    }

    public function edit(Upazila $upazila): View
    {
        $divisions = Division::active()->orderBy('name')->get();

        return view('admin.upazilas.edit', compact('upazila', 'divisions'));
    }

    public function update(Upazila $upazila): RedirectResponse
    {
        request()->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'name' => ['required', 'string', 'max:100'],
            'bn_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $upazila->update([
            'district_id' => request('district_id'),
            'name' => request('name'),
            'bn_name' => request('bn_name'),
            'is_active' => request()->boolean('is_active', true),
        ]);

        return redirect()->route('admin.upazilas.index')->with('success', 'উপজেলা আপডেট হয়েছে।');
    }

    public function destroy(Upazila $upazila): RedirectResponse
    {
        $upazila->delete();

        return back()->with('success', 'উপজেলা মুছে ফেলা হয়েছে।');
    }

    public function getByDistrict(District $district): JsonResponse
    {
        $upazilas = $district->upazilas()->active()->orderBy('name')->get(['id', 'name', 'bn_name']);

        return response()->json($upazilas);
    }
}
