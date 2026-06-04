<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promosi;
use App\Models\Cafes;
use App\Models\Tags;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PromosiController extends Controller
{
    public function index()
    {
        $promotions = Promosi::with('cafe')
            ->whereHas('cafe', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('Owner.promotion', compact('promotions'));
    }

    public function create()
    {
        $cafes = Cafes::where('user_id', Auth::id())->get();

        return view('Owner.promotion_form', [
            'promotion' => new Promosi(),
            'cafes' => $cafes,
        ]);
    }

    public function store(Request $request)
    {
        $cafes = Cafes::where('user_id', Auth::id())->get();

        if ($cafes->isEmpty()) {
            return redirect()->route('owner.promosi')->with('error', 'Tidak ada cafe tersedia untuk ditambahkan promosi. Silakan tambah cafe terlebih dahulu.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cafe_id' => ['required', Rule::exists('cafes', 'id')->where(function ($query) {
                $query->where('user_id', Auth::id());
            })],
            'img_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $imagePath = $request->file('img_url')->store('promotions', 'public');

        $promotion = Promosi::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'cafe_id' => $validated['cafe_id'],
            'img_url' => $imagePath,
            'start_date' => Carbon::parse($validated['start_date']),
            'end_date' => Carbon::parse($validated['end_date']),
        ]);

        $this->attachPromotionTag($promotion->cafe);

        return redirect()->route('owner.promosi')->with('success', 'Promosi berhasil dibuat.');
    }

    public function edit($id)
    {
        $promotion = Promosi::with('cafe')
            ->whereHas('cafe', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);

        $cafes = Cafes::where('user_id', Auth::id())->get();

        return view('Owner.promotion_form', [
            'promotion' => $promotion,
            'cafes' => $cafes,
        ]);
    }

    private function attachPromotionTag(Cafes $cafe): void
    {
        $promotionTag = Tags::firstOrCreate(['tag_name' => 'promo']);
        $cafe->tags()->syncWithoutDetaching([$promotionTag->id]);
    }

    private function detachPromotionTagIfNoPromotions(Cafes $cafe): void
    {
        if ($cafe->promotions()->count() === 0) {
            $promotionTag = Tags::where('tag_name', 'promosi')->first();
            if ($promotionTag) {
                $cafe->tags()->detach($promotionTag->id);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $promotion = Promosi::with('cafe')
            ->whereHas('cafe', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        $oldCafe = $promotion->cafe;

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cafe_id' => ['required', Rule::exists('cafes', 'id')->where(function ($query) {
                $query->where('user_id', Auth::id());
            })],
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('img_url')) {
            if ($promotion->img_url && Storage::disk('public')->exists($promotion->img_url)) {
                Storage::disk('public')->delete($promotion->img_url);
            }

            $promotion->img_url = $request->file('img_url')->store('promotions', 'public');
        }

        $promotion->title = $validated['title'];
        $promotion->description = $validated['description'];
        $promotion->cafe_id = $validated['cafe_id'];
        $promotion->start_date = Carbon::parse($validated['start_date']);
        $promotion->end_date = Carbon::parse($validated['end_date']);
        $promotion->save();

        $this->attachPromotionTag($promotion->cafe);

        if ($oldCafe && $oldCafe->id !== $promotion->cafe_id) {
            $this->detachPromotionTagIfNoPromotions($oldCafe);
        }

        return redirect()->route('owner.promosi')->with('success', 'Promosi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $promotion = Promosi::with('cafe')
            ->whereHas('cafe', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($id);
        $cafe = $promotion->cafe;

        if ($promotion->img_url && Storage::disk('public')->exists($promotion->img_url)) {
            Storage::disk('public')->delete($promotion->img_url);
        }

        $promotion->delete();

        if ($cafe) {
            $this->detachPromotionTagIfNoPromotions($cafe);
        }

        return redirect()->route('owner.promosi')->with('success', 'Promosi berhasil dihapus.');
    }
}
