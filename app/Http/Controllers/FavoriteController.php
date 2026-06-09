<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Cafes;
use Illuminate\View\View;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\Models\Navbar;
use App\Models\Rating;
use App\Models\LandingPageSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tags;
use App\Models\User;
use App\Models\Type;

class FavoriteController extends Controller
{
    public function favoriteToggle($cafeId){
        // $user = auth()->id();

        // $favorite = Favorite::where('user_id', $userId)->where('cafe_id', $cafeId)->first();

        // if($favorite){
        //     $favorite->delete();
        // }else{
        //     Favorite::create([
        //         'user_id'=>$userId,
        //         'cafe_id'=>$cafeId,
        //     ]);
        // }

        $result = auth()->user()->favoriteCafes()->toggle($cafeId);
        $isAttached = count($result['attached']) > 0;
        $message = $isAttached ? __('messages.added_to_favorite_success') : __('messages.removed_from_favorite_success');

        return back()->with('success', $message);
    }

    public function show(Request $request){
        $search = $request->input('search');
        $tagFilter = $request->input('tag');
        $kecamatanFilter = strtoupper($request->input('daerah'));
        $typesFilter=strtoupper($request->input('type'));
        
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $sortByDistance = $request->input('sort_by_distance') === 'true';

        $cafeQuery = auth()->user()->favoriteCafes()->with(['type', 'tags', 'thumbnail', 'photos', 'ratings'])->where('published', true);

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

        if($typesFilter){
            $cafeQuery->whereHas('type', function($query) use ($typesFilter){
                $query->where('id', $typesFilter);
            });
        }

        $minRating = $request->input('min_rating');
        if ($minRating) {
            $cafeQuery->where('rating', '>=', $minRating);
        }

        if ($latitude && $longitude && $sortByDistance) {
            $cafeQuery->select('*')
                ->selectRaw(
                    '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                    [$latitude, $longitude, $latitude]
                )
                ->orderBy('distance', 'asc');
        }

        $cafe = $cafeQuery->get();
        $user=Auth::user();

        $malangCity=City::whereIn('name', ['Kota Malang', 'Kabupaten Malang'])->pluck('code');
        $daftarDaerah=District::whereIn('city_code', $malangCity)->orderBy('name', 'asc')->get();

        $setting = LandingPageSetting::first() ?? new LandingPageSetting();
        $navbars = Navbar::orderBy('sort_order', 'asc')->get();
        $tags = Tags::all();
        $types = Type::all();
        $averageRating = $cafe->avg('rating');

        return view('ListCafe.favorite.favoriteCafe', compact('cafe', 'user', 'setting', 'navbars', 'tags', 'daftarDaerah', 'types', 'averageRating'));
    }
}
