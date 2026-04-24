<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DivisionController extends Controller
{
    public function index(): View
    {
        $divisions = Division::with('districts')->latest()->get();

        return view('admin.divisions.index', compact('divisions'));
    }

    public function create(): View
    {
        return view('admin.divisions.create');
    }

    public function store(): RedirectResponse
    {
        request()->validate([
            'name' => ['required', 'string', 'max:100'],
            'bn_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Division::create([
            'name' => request('name'),
            'bn_name' => request('bn_name'),
            'is_active' => request()->boolean('is_active', true),
        ]);

        return redirect()->route('admin.divisions.index')->with('success', 'বিভাগ তৈরি হয়েছে।');
    }

    public function edit(Division $division): View
    {
        return view('admin.divisions.edit', compact('division'));
    }

    public function update(Division $division): RedirectResponse
    {
        request()->validate([
            'name' => ['required', 'string', 'max:100'],
            'bn_name' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $division->update([
            'name' => request('name'),
            'bn_name' => request('bn_name'),
            'is_active' => request()->boolean('is_active', true),
        ]);

        return redirect()->route('admin.divisions.index')->with('success', 'বিভাগ আপডেট হয়েছে।');
    }

    public function destroy(Division $division): RedirectResponse
    {
        $division->delete();

        return back()->with('success', 'বিভাগ মুছে ফেলা হয়েছে।');
    }
}
