<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cafes;
use App\Models\User;
use App\Models\Role;
use App\Models\Type;
use App\Models\Tags;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\Models\Comment;

class CafeController extends Controller
{
    public function index()
    {
        // Load cafes with their relationships
        $cafes = Cafes::with(['thumbnail', 'users', 'ratings'])->withCount('views')->get();
        $averageRating = (float) Comment::whereNotNull('rating_score')->avg('rating_score');
        return view('admin.cafes', compact('cafes', 'averageRating'));
    }

    public function create()
    {
        $malangCity=City::whereIn('name', ['Kota Malang', 'Kabupaten Malang'])->pluck('code');
        $daftarDaerah=District::whereIn('city_code', $malangCity)->orderBy('name', 'asc')->get();
        $role = Role::where('name', 'owner')->first();
        $owners = User::where('role_id', $role->id)->get();
        $types = Type::all();
        $tags = Tags::all();

        return view('admin.addCafe', compact('owners', 'types', 'tags', 'daftarDaerah'));
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'owner_id' => 'exists:users,id|nullable',
            'name'=>'required|max:255|string',
            'description'=>'required',
            'type_id'=>'required|exists:types,id',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'tags'=>'nullable|array',
            'tags.*'=>'exists:tags,id',
            'thumbnail'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'photos.*'=>'image|mimes:jpeg,png,jpg|max:5120',
            'open_time'=>'nullable|array',
            'open_time.*.day_range'=>'required_with:open_time|string|max:255',
            'open_time.*.open_time'=>'required_with:open_time|date_format:H:i',
            'open_time.*.close_time'=>'required_with:open_time|date_format:H:i',
            'phone_number'=>['required'],
            'email'=>'required|email:rfc,dns',
            'address'=>'required',
            'maps'=>'required|url',
            'menu_items'=>'nullable|array',
            'menu_items.*.name'=>'required_with:menu_items|string|max:255',
            'menu_items.*.description'=>'nullable|string',
            'menu_items.*.price'=>'required_with:menu_items|numeric',
            'menu_items.*.image'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $response=Http::withHeaders([
            'User-Agent'=>'Laravel'
        ])->get('https://nominatim.openstreetmap.org/reverse', [
            'format'=>'json',
            'lat'=>$credentials['latitude'],
            'lon'=>$credentials['longitude']
        ]);

        $data=$response->json();

        $kecamatan =
                    $data['address']['city_district']
                    ?? $data['address']['suburb']
                    ?? $data['address']['town']
                    ?? $data['address']['village']
                    ?? $data['address']['county']
                    ?? 'Tidak diketahui';
        try{
            DB::transaction(function() use ($credentials, $kecamatan, $request){
                $cafe = Cafes::create([
                    'user_id' => $credentials['owner_id'] ?? auth()->id(),
                    'name' => $credentials['name'],
                    'description' => $credentials['description'],
                    'type_id' => $credentials['type_id'],
                    'num_phone' => $credentials['phone_number'],
                    'address' => $credentials['address'],
                    'email' => $credentials['email'],
                    'latitude' => $credentials['latitude'],
                    'longitude' => $credentials['longitude'],
                    'maps_link' => $credentials['maps'],
                    'kecamatan' => $kecamatan,
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

            return redirect()->route('admin.cafes')->with('success', 'Cafe berhasil dibuat!');

        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $cafe = Cafes::with(['type', 'tags', 'thumbnail', 'photos', 'operationalTime', 'menuItems'])
            ->findOrFail($id);
            
        if ($cafe->user_id !== auth()->id()) {
            return redirect()->route('admin.cafes')->with('error', 'Anda tidak memiliki akses untuk mengedit cafe ini karena sudah memiliki owner.');
        }

        $malangCity=City::whereIn('name', ['Kota Malang', 'Kabupaten Malang'])->pluck('code');
        $daftarDaerah=District::whereIn('city_code', $malangCity)->orderBy('name', 'asc')->get();
        $role = Role::where('name', 'owner')->first();
        $owners = User::where('role_id', $role->id)->get();
        $types = Type::all();
        $tags = Tags::all();

        return view('admin.editCafe', compact('cafe', 'owners', 'types', 'tags', 'daftarDaerah'));
    }

    public function update(Request $request, $id)
    {
        $cafe = Cafes::findOrFail($id);
        
        if ($cafe->user_id !== auth()->id()) {
            return redirect()->route('admin.cafes')->with('error', 'Anda tidak memiliki akses untuk mengedit cafe ini.');
        }

        $credentials = $request->validate([
            'owner_id' => 'exists:users,id|nullable',
            'name'=>'required|max:255|string',
            'description'=>'required',
            'type_id'=>'required|exists:types,id',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'kecamatan' => ['required', 'exists:indonesia_districts,id'],
            'tags'=>'nullable|array',
            'tags.*'=>'exists:tags,id',
            'thumbnail'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'photos.*'=>'image|mimes:jpeg,png,jpg|max:5120',
            'open_time'=>'nullable|array',
            'open_time.*.day_range'=>'required_with:open_time|string|max:255',
            'open_time.*.open_time'=>'required',
            'open_time.*.close_time'=>'required',
            'phone_number'=>['required'],
            'email'=>'required|email:rfc,dns',
            'address'=>'required',
            'maps'=>'required|url',
            'menu_items'=>'nullable|array',
            'menu_items.*.id'=>['nullable'],
            'menu_items.*.name'=>'required_with:menu_items|string|max:255',
            'menu_items.*.description'=>'nullable|string',
            'menu_items.*.price'=>'required_with:menu_items|numeric',
            'menu_items.*.image'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'is_published'=>['nullable','boolean'],
        ]);

        $isPublished = $request->boolean('is_published');

        try {
            DB::transaction(function() use ($credentials, $request, $cafe, $isPublished){
                $cafe->update([
                    'user_id' => $credentials['owner_id'] ?? auth()->id(),
                    'name' => $credentials['name'],
                    'description' => $credentials['description'],
                    'type_id' => $credentials['type_id'],
                    'num_phone' => $credentials['phone_number'],
                    'address' => $credentials['address'],
                    'email' => $credentials['email'],
                    'latitude' => $credentials['latitude'],
                    'longitude' => $credentials['longitude'],
                    'maps_link' => $credentials['maps'],
                    'kecamatan' => District::find($credentials['kecamatan'])->name ?? null,
                    'published' => $isPublished,
                ]);

                if($request->has('tags')){
                    $cafe->tags()->sync($credentials['tags']);
                }

                if($request->has('open_time')){
                    $cafe->operationalTime()->delete();
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
                    if ($cafe->thumbnail) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($cafe->thumbnail->photo_url);
                        $cafe->thumbnail()->update(['photo_url' => $thumbPath]);
                    } else {
                        $cafe->thumbnail()->create(['photo_url' => $thumbPath]);
                    }
                }

                if (isset($credentials['menu_items'])) {
                    $keepMenuIds = collect($credentials['menu_items'])->pluck('id')->filter()->toArray();
                    $cafe->menuItems()->whereNotIn('id', $keepMenuIds)->delete();

                    foreach ($credentials['menu_items'] as $index => $item) {
                        if (isset($item['id']) && $item['id'] != '') {
                            $menuItem = $cafe->menuItems()->findOrFail($item['id']);
                            $imagePath = $menuItem->img_url;
                        } else {
                            $menuItem = new \App\Models\Menu();
                            $menuItem->cafe_id = $cafe->id;
                            $imagePath = null;
                        }

                        if ($request->hasFile("menu_items.$index.image")) {
                            if ($menuItem->exists && $menuItem->img_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($menuItem->img_url)) {
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($menuItem->img_url);
                            }
                            $imagePath = $request->file("menu_items.$index.image")->store('cafes/menus', 'public');
                        }

                        $menuItem->name = $item['name'];
                        $menuItem->description = $item['description'];
                        $menuItem->price = $item['price'];
                        $menuItem->img_url = $imagePath;
                        $menuItem->save();
                    }
                }
            });

            return redirect()->route('admin.cafes')->with('success', 'Cafe berhasil diperbarui!');

        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
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
