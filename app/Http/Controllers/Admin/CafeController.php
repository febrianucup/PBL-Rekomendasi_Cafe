<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index()
    {
        // Load cafes with their relationships
        $cafes = \App\Models\Cafes::with(['thumbnail', 'users'])->get();
        return view('admin.cafes', compact('cafes'));
    }

    public function destroy($id)
    {
        $cafe = \App\Models\Cafes::with(['photos', 'thumbnail', 'operationalTime', 'menuItems', 'tags'])->findOrFail($id);

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($cafe) {
                if ($cafe->thumbnail) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cafe->thumbnail->photo_url)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($cafe->thumbnail->photo_url);
                    }
                    $cafe->thumbnail()->delete();
                }

                foreach ($cafe->photos as $photo) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($photo->photo_url)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->photo_url);
                    }
                }
                $cafe->photos()->delete();

                if ($cafe->menuItems->isNotEmpty()) {
                    foreach ($cafe->menuItems as $menu) {
                        if ($menu->img_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->img_url)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->img_url);
                        }
                    }
                    $cafe->menuItems()->delete();
                }

                $cafe->operationalTime()->delete();
                $cafe->tags()->detach();
                $cafe->delete();
            });

            return redirect()->route('admin.cafes')->with('success', 'Cafe successfully deleted.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete cafe: ' . $e->getMessage());
        }
    }
}
