<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * List all sliders ordered by sort_order.
     */
    public function index(): View
    {
        $sliders = Slider::orderBy('sort_order')->paginate(20);

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the create slider form.
     */
    public function create(): View
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a new slider.
     */
    public function store(SliderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('sliders', 'public');
        $data['is_active'] = $request->boolean('is_active', true);

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'স্লাইডার সফলভাবে যোগ করা হয়েছে।');
    }

    /**
     * Show the edit slider form.
     */
    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update an existing slider.
     */
    public function update(SliderRequest $request, Slider $slider): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!isset($data['is_active'])) {
            $data['is_active'] = false;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        } else {
            unset($data['image']);
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'স্লাইডার সফলভাবে আপডেট হয়েছে।');
    }

    /**
     * Delete a slider.
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'স্লাইডার মুছে ফেলা হয়েছে।');
    }
}
