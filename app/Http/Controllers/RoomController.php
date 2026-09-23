<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelModel;
use App\Models\RoomModel;
use App\Services\BookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index(Request $request, BookingService $bookingService)
{
     $hotelId = $request->input('hotel_id');
     $hotel = HotelModel::findOrFail($hotelId);

     $query = RoomModel::where('hotel_id', $hotelId)->withAvg('reviews', 'rating')

     ->when($request->filled('room_number'), function($query) use ($request){
        $search = $request->input('room_number');
        $query->where('room_number', 'like', "%{$search}%");
     })
     ->when($request->filled('room_type'), function($query) use ($request){
        $search = $request->input('room_type');
        $query->where('type', 'like', "%{$search}%");
     });

     $rooms = $query->get();

     return view('rooms', compact('rooms', 'hotel'));
}

     public function show($id){

        $room = RoomModel::withAvg('reviews', 'rating')->findOrFail($id);

        return view('room', compact('room'));
    }

    public function show_update($id){

        $room = HotelModel::findOrFail($id); 

        return view('edit_room', compact('room'));
    }
    
    public function store(Request $request){

    $validator = Validator::make($request->all(), [

        'hotel_id' => 'required',
        'room_number' => 'required',
        'price' => 'required',
        'type' => 'required',
        'places' => 'required',
        'description' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png',
        ],

        [
        'hotel_id.required' => 'Must have',
        'room_number.required' => 'Must have',
        'price.required' => 'Must have',
        'type.required' => 'Must have',
        'description.required' => 'Must have',
        'places.required' => 'Must have',
        ] 
    );
    
    if($validator->fails()){
        return redirect()->back()->withErrors($validator);
    }
    $room = $validator->validated();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('rooms', 'public');
        $room['image'] = $path; 
    }
    
    RoomModel::create($room);

    return redirect()->route('rooms')->with('success', 'Room is toegevoegd');

    }

    public function update(Request $request, $id){
        
    $room = RoomModel::findOrFail($id); 

    $validator = Validator::make($request->all(), [
        
        'room_number' => 'required',
        'price' => 'required',
        'type' => 'required',
        'places' => 'required',
        'description' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png',
        ],

        [
        'room_number.required' => 'Must have',
        'price.required' => 'Must have',
        'type.required' => 'Must have',
        'description.required' => 'Must have',
        'places.required' => 'Must have',
        ] 
    );
    
    if($validator->fails()){
        return redirect()->back()->withErrors($validator);
    }
    $data = $validator->validated();

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('rooms', 'public');
        $data['image'] = $path; 
    }
    
    $room->update($data);

    return redirect()->route('rooms')->with('success', 'Room is geupdated');

    }

    public function destroy($id){

        $room = RoomModel::findOrFail($id);
        $room->bookings()->delete();
        $room->reviews()->delete();
        $room->delete();
        return redirect()->route('rooms')->with('success', 'Room is deleted');
    }
}


