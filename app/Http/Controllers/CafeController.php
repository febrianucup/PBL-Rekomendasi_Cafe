<?php

namespace App\Http\Controllers;

use App\Models\Cafes;
use App\Models\Menu;
use App\Models\OperationalTime;
use App\Models\Tags;
use App\Models\User;
use App\Models\Type;
use Faker\Provider\id_ID\PhoneNumber;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

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
        $menus=Menu::whereCafeId($id)->paginate(6);

        return view('DetailCafe.detailCafe', compact('cafe', 'user', 'menus'));
    }

    public function ownerDashboard($id = null)
    {
        $cafes = Cafes::where('user_id', Auth::id())
            ->with(['thumbnail', 'type'])
            ->get();

        return view('Owner.Dashboard', compact('cafes'));
    }

    public function showOwner($id)
    {
        $cafe = Cafes::with(['type', 'tags', 'thumbnail', 'photos', 'operationalTime', 'menuItems'])
            ->findOrFail($id);

        if ($cafe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melihat cafe ini.');
        }

        return view('Owner.profile.show', compact('cafe'));
    }

    public function edit($id){
        $cafe = Cafes::with(['type', 'tags', 'thumbnail', 'photos', 'operationalTime', 'menuItems'])
            ->findOrFail($id);
        
        if ($cafe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit cafe ini.');
        }

        return view('Owner.profile.edit', [
            'cafe' => $cafe,
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
                    'kecamatan'=>$kecamatan,
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

            return redirect()->route('owner.dashboard')->with('success', 'Cafe berhasil dipublikasikan!');

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
            'thumbnail'=>'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'photos.*'=>'image|mimes:jpeg,png,jpg|max:5120',
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
                    ?? $data['address']['village'];

        try {
            DB::transaction(function () use ($credentials, $kecamatan, $request, $id) {
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
                    'kecamata' => $kecamatan,
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

            return redirect()->route('owner.dashboard')->with('success', 'Cafe berhasil diperbarui!');
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

            return redirect()->route('owner.dashboard')->with('success', 'Cafe berhasil dihapus secara permanen.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus cafe: ' . $e->getMessage());
        }
    }
}
