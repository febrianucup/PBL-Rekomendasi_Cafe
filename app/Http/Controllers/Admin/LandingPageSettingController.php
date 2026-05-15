<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingPageSettingController extends Controller
{
    public function index()
    {
        $setting = \App\Models\LandingPageSetting::first() ?? new \App\Models\LandingPageSetting();
        return view('admin.beranda_settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'remove_images' => 'nullable|array'
        ]);

        $setting = \App\Models\LandingPageSetting::first();
        if (!$setting) {
            $setting = new \App\Models\LandingPageSetting();
        }

        $setting->title = $validated['title'];
        $setting->description = $validated['description'];

        $currentImages = $setting->slider_images ?? [];

        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $img) {
                if (($key = array_search($img, $currentImages)) !== false) {
                    unset($currentImages[$key]);
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($img)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($img);
                    }
                }
            }
            $currentImages = array_values($currentImages);
        }

        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $file) {
                $path = $file->store('landing_page/sliders', 'public');
                $currentImages[] = $path;
            }
        }

        $setting->slider_images = $currentImages;
        $setting->save();

        return redirect()->back()->with('success', 'Beranda settings updated successfully.');
    }
}
