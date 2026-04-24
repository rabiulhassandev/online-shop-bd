<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DistrictController extends Controller
{
    public function index(): View
    {
        $districts = District::with(['division', 'upazilas'])->latest()->get();

        return view('admin.districts.index', compact('districts'));
    }

    public function create(): View
    {
        $divisions = Division::active()->orderBy('name')->get();

        return view('admin.districts.create', compact('divisions'));
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'division_id' => ['required', 'exists:divisions,id'],
            'name' => ['required', 'string', 'max:100'],
            'bn_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        District::create([
            'division_id' => request('division_id'),
            'name' => request('name'),
            'bn_name' => request('bn_name'),
            'is_active' => request()->boolean('is_active', true),
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'জেলা তৈরি হয়েছে।');
    }

    public function edit(District $district): View
    {
        $divisions = Division::active()->orderBy('name')->get();

        return view('admin.districts.edit', compact('district', 'divisions'));
    }

    public function update(District $district): RedirectResponse
    {
        request()->validate([
            'division_id' => ['required', 'exists:divisions,id'],
            'name' => ['required', 'string', 'max:100'],
            'bn_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $district->update([
            'division_id' => request('division_id'),
            'name' => request('name'),
            'bn_name' => request('bn_name'),
            'is_active' => request()->boolean('is_active', true),
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'জেলা আপডেট হয়েছে।');
    }

    public function destroy(District $district): RedirectResponse
    {
        $district->delete();

        return back()->with('success', 'জেলা মুছে ফেলা হয়েছে।');
    }

    public function getByDivision(Division $division): JsonResponse
    {
        $districts = $division->districts()->active()->orderBy('name')->get(['id', 'name', 'bn_name']);

        return response()->json($districts);
    }
}
