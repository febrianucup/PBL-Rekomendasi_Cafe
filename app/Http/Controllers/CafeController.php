<?php

namespace App\Http\Controllers;

use App\Models\Cafes;
use App\Models\OperationalTime;
use App\Models\Tags;
use App\Models\Type;
use Faker\Provider\id_ID\PhoneNumber;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CafeController extends Controller
{
    public function index(){
        $cafe=Cafes::with(['type', 'thumbnail', 'photos'])->get();
        $user=Auth::user();

        return view('ListCafe.listCafe', compact('cafe', 'user'));
    }

    public function show($id){
        $cafe=Cafes::with(['type', 'tags', 'photos', 'thumbnail', 'operationalTime', 'menuItems'])
            ->findOrFail($id);
        $user=Auth::user();

        return view('DetailCafe.detailCafe', compact('cafe', 'user'));
    }

    public function edit(){
        return view('Owner.profile.edit', [
            'types' => Type::all(),
            'tags' => Tags::all(),
        ]);
    }

    public function create(){
        return view('Owner.profile.add-cafe', [
            'types' => Type::all(),
            'tags' => Tags::all(),
        ]);
    }

    public function addCafe(Request $request){
        $credentials = $request->validate([
            'name'=>'required|max:255|string',
            'description'=>'required',
            'type_id'=>'required|exists:types,id',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'tags'=>'nullable|array',
            'tags.*'=>'exists:tags,id',
            'thumbnail'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*'=>'image|mimes:jpeg,png,jpg|max:2048',
            'open_time'=>'nullable|array',
            'open_time.*.day_range'=>'required_with:open_time|string|max:255',
            'open_time.*.open_time'=>'required_with:open_time|date_format:H:i',
            'open_time.*.close_time'=>'required_with:open_time|date_format:H:i',
            'phone_number'=>['required', 'phone:ID'],
            'email'=>'required|email:rfc,dns',
            'address'=>'required',
            'maps'=>'required|url',
            'menu_items'=>'nullable|array',
            'menu_items.*.name'=>'required_with:menu_items|string|max:255',
            'menu_items.*.description'=>'nullable|string',
            'menu_items.*.price'=>'required_with:menu_items|numeric',
            'menu_items.*.image'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try{
            DB::transaction(function() use ($credentials, $request){
                $cafe=Cafes::create([
                    'user_id'=>Auth::id(),
                    'name'=>$credentials['name'],
                    'description'=>$credentials['description'],
                    'type_id'=>$credentials['type_id'],
                    'num_phone'=>$credentials['phone_number'],
                    'address'=>$credentials['address'],
                    'email'=>$credentials['email'],
                    'latitude'=>$credentials['latitude'],
                    'longitude'=>$credentials['longitude'],
                    'maps_link'=>$credentials['maps'],
                ]);

                if($request->has('tags')){
                    $cafe->tags()->sync($credentials['tags']);
                }

                if($request->has('open_time')){
                    foreach($credentials['open_time'] as $hours){
                        $cafe->operationalTime()->create([
                            'day_range'=>$hours['day_range'],
                            'open_time'=>$hours['open_time'],
                            'close_time'=>$hours['close_time'],
                        ]);
                    }
                }

                if($request->hasFile('photos')){
                    foreach($request->file('photos') as $file){
                        $path=$file->store('cafes/gallery', 'public');
                        $cafe->photos()->create([
                            'photo_url'=>$path,
                        ]);
                    }
                }

                if ($request->hasFile('thumbnail')) {
                    $thumbPath = $request->file('thumbnail')->store('cafes/thumbnails', 'public');
                    $cafe->thumbnail()->create([
                        'photo_url' => $thumbPath,
                    ]);
                }

                if($request->has('menu_items')){
                    foreach($credentials['menu_items'] as $index=>$items){
                        $imagePath=null;
                        if ($request->hasFile("menu_items.$index.image")) {
                            $imagePath = $request->file("menu_items.$index.image")->store('cafes/menus', 'public');
                        }
                        $cafe->menuItems()->create([
                            'name' => $items['name'],
                            'description' => $items['description'],
                            'price' => $items['price'],
                            'img_url' => $imagePath,
                        ]);
                    }
                }
                
                return $cafe;
            });

            return redirect()->route('add-cafe')->with('success', 'Cafe berhasil dipublikasikan!');

        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateCafe(Request $request, $id){
        $credentials = $request->validate([
            'name'=>'required|max:255|string',
            'description'=>'required',
            'type_id'=>'required|exists:types,id',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'tags'=>'nullable|array',
            'tags.*'=>'exists:tags,id',
            'thumbnail'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*'=>'image|mimes:jpeg,png,jpg|max:2048',
            'open_time'=>'nullable|array',
            'open_time.*.day_range'=>'required_with:open_time|string|max:255',
            'open_time.*.open_time'=>'required_with:open_time|date_format:H:i',
            'open_time.*.close_time'=>'required_with:open_time|date_format:H:i',
            'phone_number'=>['required', 'phone:ID'],
            'email'=>'required|email:rfc,dns',
            'address'=>'required',
            'maps'=>'required|url',
            'menu_items'=>'nullable|array',
            'menu_items.*.name'=>'required_with:menu_items|string|max:255',
            'menu_items.*.description'=>'nullable|string',
            'menu_items.*.price'=>'required_with:menu_items|numeric',
            'menu_items.*.image'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::transaction(function () use ($credentials, $request, $id) {
                $cafe = Cafes::findOrFail($id);
                $cafe->update([
                    'user_id'=>Auth::id(),
                    'name' => $credentials['name'],
                    'description' => $credentials['description'],
                    'type_id' => $credentials['type_id'],
                    'num_phone' => $credentials['phone_number'],
                    'address' => $credentials['address'],
                    'email' => $credentials['email'],
                    'latitude' => $credentials['latitude'],
                    'longitude' => $credentials['longitude'],
                    'maps_link' => $credentials['maps'],
                ]);

                if (isset($credentials['tags'])) {
                    $cafe->tags()->sync($credentials['tags']);
                }

                if (isset($credentials['open_time'])) {
                    $cafe->operationalTime()->delete();
                    foreach ($credentials['open_time'] as $hours) {
                        $cafe->operationalTime()->create([
                            'day_range' => $hours['day_range'],
                            'open_time' => $hours['open_time'],
                            'close_time' => $hours['close_time'],
                        ]);
                    }
                }

                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $file) {
                        $path = $file->store('cafes/gallery', 'public');
                        $cafe->photos()->create([
                            'photo_url' => $path,
                        ]);
                    }
                }

                if ($request->hasFile('thumbnail')) {
                    $thumbPath = $request->file('thumbnail')->store('cafes/thumbnails', 'public');
                    if ($cafe->thumbnail) {
                        Storage::disk('public')->delete($cafe->thumbnail->photo_url);
                        $cafe->thumbnail()->update(['photo_url' => $thumbPath]);
                    } else {
                        $cafe->thumbnail()->create(['photo_url' => $thumbPath]);
                    }
                }

                if (isset($credentials['menu_items'])) {
                    $cafe->menuItems()->delete();
                    foreach ($credentials['menu_items'] as $index => $item) {
                        $imagePath = null;
                        if ($request->hasFile("menu_items.$index.image")) {
                            $imagePath = $request->file("menu_items.$index.image")->store('cafes/menus', 'public');
                        }
                        $cafe->menuItems()->create([
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'price' => $item['price'],
                            'img_url' => $imagePath,
                        ]);
                    }
                }
            });

            return redirect()->back()->with('success', 'Cafe berhasil diperbarui!');
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $cafe = Cafes::with(['photos', 'thumbnail', 'operationalTime', 'menuItems', 'tags'])->findOrFail($id);

        if (auth()->user()->id !== $cafe->user_id && auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus cafe ini.');
        }

        try {
            DB::transaction(function () use ($cafe) {
                if ($cafe->thumbnail) {
                    if (Storage::disk('public')->exists($cafe->thumbnail->photo_url)) {
                        Storage::disk('public')->delete($cafe->thumbnail->photo_url);
                    }
                    $cafe->thumbnail()->delete();
                }

                foreach ($cafe->photos as $photo) {
                    if (Storage::disk('public')->exists($photo->photo_url)) {
                        Storage::disk('public')->delete($photo->photo_url);
                    }
                }
                $cafe->photos()->delete();

                if ($cafe->menuItems->isNotEmpty()) {
                    foreach ($cafe->menuItems as $menu) {
                        if ($menu->img_url && Storage::disk('public')->exists($menu->img_url)) {
                            Storage::disk('public')->delete($menu->img_url);
                        }
                    }
                    $cafe->menuItems()->delete();
                }

                $cafe->operationalTime()->delete();
                $cafe->tags()->detach();
                $cafe->delete();
            });

            return redirect()->route('cafe')->with('success', 'Cafe berhasil dihapus secara permanen.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus cafe: ' . $e->getMessage());
        }
    }
}
