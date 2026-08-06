<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelModel;
use App\Models\AmenitiesModel;
use App\Models\MealModel;
use App\Models\RulesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Torann\GeoIP\Facades\GeoIP;
use Carbon\Carbon;
use App\Services\WeatherService;

class HotelController extends Controller
{
    public function index(Request $request, WeatherService $weatherService)
{
    $time = Carbon::now()->format('H:i');;

    $query = HotelModel::withAvg('reviews', 'rating');
     
    if ($request->filled('search_hotel')) {
        $search = $request->input('search_hotel');
        $query->where('name', 'like', "%{$search}%");
    }

    $hotels = $query->get();
    $weatherData = $weatherService->weather($request);

    if ($weatherData['weather']) {
        return view('hotels', [
            'weather' => $weatherData['weather'],
            'city'    => $weatherData['city'],
            'hotels' => $hotels,
            'time' => $time
        ]);
    }

    return view('hotels', [
        'error' => 'Failed to fetch weather data.',
        'hotels' => $hotels,
        'time' => $time
    ]);
}

    public function show($id){

        $hotel = HotelModel::withAvg('reviews', 'rating')
        ->with(['amenities','meals', 'rules' ])
        ->findOrFail($id);

        return view('hotel', compact('hotel'));
    }

    public function show_update($id){

        $hotel = HotelModel::findOrFail($id); 

        return view('edit_hotel', compact('hotel'));
    }
    
    public function store(Request $request){
        
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'adres' => 'required',
        'price' => 'required',
        'places' => 'required',
        'description' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png',
        ],

        [
        'name.required' => 'Must have',
        'adres.required' => 'Must have',
        'description.required' => 'Must have',
        'price.required' => 'Must have',
        'places.required' => 'Must have',
        ] 
    );
    
    if($validator->fails()){
        return redirect()->back()->withErrors($validator);
    }
    $hotel = $validator->validated();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('hotels', 'public');
        $hotel['image'] = $path; 
    }
    
    HotelModel::create($hotel);

    return redirect()->route('hotels')->with('success', 'Hotel is toegevoegd');

    }

    public function update(Request $request, $id){
        
    $hotel = HotelModel::findOrFail($id); 

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'adres' => 'required',
        'price' => 'required',
        'description' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png',
        ],

        [
        'name.required' => 'Must have',
        'adres.required' => 'Must have',
        'description.required' => 'Must have',
        'price.required' => 'Must have',
        ] 
    );
    
    if($validator->fails()){
        return redirect()->back()->withErrors($validator);
    }
    $data = $validator->validated();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('hotels', 'public');
        $data['image'] = $path; 
    }
    
    $hotel->update($data);

    return redirect()->route('hotels')->with('success', 'Hotel is geupdated');

    }

    public function destroy($id){
        $hotel = HotelModel::findOrFail($id);
        $hotel->bookings()->delete();
        $hotel->reviews()->delete();
        $hotel->delete();
        return redirect()->route('hotels')->with('success', 'hotel is deleted');
    }
}

