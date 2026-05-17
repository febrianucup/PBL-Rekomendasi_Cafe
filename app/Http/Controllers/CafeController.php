<?php

namespace App\Http\Controllers;

use App\Models\Cafes;
use App\Models\Menu;
use App\Models\OperationalTime;
use App\Models\Tags;
use App\Models\User;
use App\Models\Type;
use App\Models\Thumbnail;
use App\Models\LandingPageSetting;
use Faker\Provider\id_ID\PhoneNumber;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use App\Models\Navbar;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Validation\Validator;

class CafeController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $tagFilter = $request->input('tag');
        $kecamatanFilter = strtoupper($request->input('daerah'));

        $cafeQuery = Cafes::with(['type', 'tags', 'thumbnail', 'photos']);

        if ($search){
            $cafeQuery->where(function($query) use ($search){
                $query->where('name', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%");
            });
        }

        if ($tagFilter){
            $cafeQuery->whereHas('tags', function($query) use ($tagFilter){
                $query->where('tag_name', $tagFilter);
            });
        }

        if ($kecamatanFilter){
            $kecamatan=District::find($kecamatanFilter);
            if($kecamatan){
                $cafeQuery->where(function($query) use ($kecamatan){
                    $query->where('kecamatan', $kecamatan->name);
            
                });
            }else{
                $cafeQuery->where('kecamatan', '');
            }
        }

        $cafe = $cafeQuery->get();

        $user=Auth::user();

        $malangCity=City::whereIn('name', ['Kota Malang', 'Kabupaten Malang'])->pluck('code');
        $daftarDaerah=District::whereIn('city_code', $malangCity)->orderBy('name', 'asc')->get();
        
        $setting = LandingPageSetting::first() ?? new LandingPageSetting();
        $navbars = Navbar::orderBy('sort_order', 'asc')->get();
        $tags = Tags::all();

        return view('ListCafe.listCafe', compact('cafe', 'user', 'setting', 'navbars', 'tags', 'daftarDaerah'));
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
        $id = $id === null ? Auth::id() : (int) $id;

        if ($id !== Auth::id()) {
            return redirect()->route('owner.dashboard', ['id' => Auth::id()]);
        }

        $cafes = Cafes::where('user_id', $id)
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
        $malangCity=City::whereIn('name', ['Kota Malang', 'Kabupaten Malang'])->pluck('code');
        $daftarDaerah=District::whereIn('city_code', $malangCity)->orderBy('name', 'asc')->get();
        
        if ($cafe->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit cafe ini.');
        }

        return view('Owner.profile.edit', [
            'cafe' => $cafe,
            'types' => Type::all(),
            'tags' => Tags::all(),
            'daftarDaerah' => $daftarDaerah,
        ]);
    }

    public function create()
    {
        $malangCity=City::whereIn('name', ['Kota Malang', 'Kabupaten Malang'])->pluck('code');
        $daftarDaerah=District::whereIn('city_code', $malangCity)->orderBy('name', 'asc')->get();

        $user = Auth::user();
        $types = Type::all();
        $tags = Tags::all();
        return view('Owner.profile.add-cafe', compact('user', 'types', 'tags', 'daftarDaerah'));
    }

    public function addCafe(Request $request){
        $credentials = $request->validate([
            'name'=>['required','max:255','string'],
            'description'=>['required'],
            'type_id'=>['required','exists:types,id'],
            'kecamatan' => ['required','exists:indonesia_districts,id'],
            'latitude'=>['required','numeric'],
            'longitude'=>['required','numeric'],
            'tags'=>['nullable','array'],
            'tags.*'=>['exists:tags,id'],
            'thumbnail'=>['nullable','image','mimes:jpeg,png,jpg','max:5120'],
            'photos.*'=>['image','mimes:jpeg,png,jpg','max:5120'],
            'open_time'=> ['nullable', 'array'],
            'open_time.*.day_range'  => ['required_with:open_time', 'string', 'max:255'],
            'open_time.*.open_time'  => ['required_with:open_time', 'date_format:H:i'],
            'open_time.*.close_time' => ['required_with:open_time', 'date_format:H:i'],
            'phone_number'=>['required'],
            'email'=>['required','email:rfc,dns'],
            'address'=>['required'],
            'maps'=>['required','url'],
            'menu_items'=>['nullable','array'],
            'menu_items.*.name'=>['required_with:menu_items','string','max:255'],
            'menu_items.*.description'=>['nullable','string'],
            'menu_items.*.price'=>['required_with:menu_items','numeric'],
            'menu_items.*.image'=>['nullable','image','mimes:jpeg,png,jpg','max:5120'],
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
                    'kecamatan'=>$credentials['kecamatan'] ? District::find($credentials['kecamatan'])->name : null,
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
        // 1. Validasi Data Form
        $credentials = $request->validate([
            'name'=>['required','max:255','string'],
            'description'=>['required'],
            'type_id'=>['required','exists:types,id'],
            'kecamatan' => ['required', 'exists:indonesia_districts,id'],
            'latitude'=>['required','numeric'],
            'longitude'=>['required','numeric'],
            'tags'=>['nullable','array'],
            'tags.*'=>['exists:tags,id'],
            'thumbnail'=>['nullable','image','mimes:jpeg,png,jpg','max:5120'],
            'photos.*'=>['image','mimes:jpeg,png,jpg','max:5120'],
            'open_time'=> ['nullable', 'array'],
            'open_time.*.day_range'  => ['required_with:open_time', 'string', 'max:255'],
            'open_time.*.open_time'  => ['required', 'date_format:H:i:s,H:i'],
            'open_time.*.close_time' => ['required', 'date_format:H:i:s,H:i'],
            'phone_number'=>['required'],
            'email'=>['required','email:rfc,dns'],
            'address'=>['required'],
            'maps'=>['required','url'],
            'menu_items'=>['nullable','array'],
            'menu_items.*.id'=>['nullable'],
            'menu_items.*.name'=>['required_with:menu_items','string','max:255'],
            'menu_items.*.description'=>['nullable','string'],
            'menu_items.*.price'=>['required_with:menu_items','numeric'],
            'menu_items.*.image'=>['nullable','image','mimes:jpeg,png,jpg','max:5120'],
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
                    'kecamatan' => $credentials['kecamatan'] ? District::find($credentials['kecamatan'])->name : null,
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
                    $keepMenuIds = collect($credentials['menu_items'])->pluck('id')->filter()->toArray();

                    $cafe->menuItems()->whereNotIn('id', $keepMenuIds)->delete();

                    foreach ($credentials['menu_items'] as $index => $item) {
                        
                        if (isset($item['id']) && $item['id'] != '') {
                            $menuItem = $cafe->menuItems()->findOrFail($item['id']);
                            $imagePath = $menuItem->img_url;
                        } else {
                            $menuItem = new Menu();
                            $menuItem->cafe_id = $cafe->id;
                            $imagePath = 'cafes/menus/default-menu.jpg';
                        }

                        if ($request->hasFile("menu_items.$index.image")) {
                            if ($menuItem->exists && $menuItem->img_url && Storage::disk('public')->exists($menuItem->img_url)) {
                                Storage::disk('public')->delete($menuItem->img_url);
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
