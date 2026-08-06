<?php

namespace App\Services;

use App\Models\BookingModel;
use App\Models\HotelModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingService
{
    /**
     * Create a new class instance.
     */
   public function create(array $data)
    {
        
        $validator = Validator::make($data, [
            'hotel_id' => 'required',
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'persons' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $hotel = HotelModel::findOrFail($data['hotel_id']);
        $check_in = Carbon::parse($data['check_in']);
        $check_out = Carbon::parse($data['check_out']);
        $today = Carbon::today();

        if ($check_in->lt($today)) {
            throw new \Exception('Kan niet vroeger dan vandaag zijn!');
        }

        if ($check_out->lte($check_in)) {
            $check_out = $check_in->copy()->addDay();
        }

        $nights = max(1, $check_in->diffInDays($check_out));

        $places = $hotel->places;
        $requestedPlaces = $data['persons'];

        $occupiedPlaces = BookingModel::where('hotel_id', $hotel->id)
            ->where(function ($query) use ($check_in, $check_out) {
                $query->where('check_in', '<', $check_out)
                      ->where('check_out', '>', $check_in);
            })
            ->sum('persons');

        $availablePlaces = $places - $occupiedPlaces;

        if ($requestedPlaces > $availablePlaces) {
            throw new \Exception('Er zijn weinig plekken');
        }

        $totalPrice = $nights * $requestedPlaces * $hotel->price;

        return BookingModel::create([
            'hotel_id' => $hotel->id,
            'user_id' => Auth::id(),
            'check_in' => $check_in->toDateString(),
            'check_out' => $check_out->toDateString(),
            'persons' => $requestedPlaces,
            'total_price' => $totalPrice,
            'places' => $occupiedPlaces,
        ]);
    }

    public function plus(array $data){

        $hotel = HotelModel::findOrFail($data['hotel_id']);
        $check_in = Carbon::parse($data['check_in']);
        $check_out = Carbon::parse($data['check_out']);
        $nights = $check_in->diffInDays($check_out);
        
        $persons = session('persons', $data['persons']);
        $persons++;
        
        $today = Carbon::today(); 

        if ($nights < 1){
        $nights = 1;
    }

        $TotalPrice = $nights * $persons * $hotel->price;

        session([
        'persons' => $persons, 
        'total_price' => $TotalPrice,
        'check_in' => $check_in->format('Y-m-d'),
        'check_out' => $check_out->format('Y-m-d'),
        ]);
    }

    public function min(array $data){

        $hotel = HotelModel::findOrFail($data['hotel_id']);
        $check_in = Carbon::parse($data['check_in']);
        $check_out = Carbon::parse($data['check_out']);
        $nights = $check_in->diffInDays($check_out);
        
        $persons = session('persons', $data['persons']);
        $persons--;
        
        $today = Carbon::today(); 

        if ($nights < 1){
        $nights = 1;
    }

        $TotalPrice = $nights * $persons * $hotel->price;

        session([
        'persons' => $persons, 
        'total_price' => $TotalPrice,
        'check_in' => $check_in->format('Y-m-d'),
        'check_out' => $check_out->format('Y-m-d'),
        ]);
    }
}
