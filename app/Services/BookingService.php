<?php

namespace App\Services;

use App\Models\BookingModel;
use App\Models\RoomModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingService
{
    /**
     * Create a new class instance.
     */

    public function avaliablePlaces($room, $check_in, $check_out){

    $check_in = $check_in ? Carbon::parse($check_in) : Carbon::today();
    $check_out = $check_out ? Carbon::parse($check_out) : Carbon::tomorrow();

    $occupiedPlaces = BookingModel::where('room_id', $room->id)
            ->where(function ($query) use ($check_in, $check_out) {
                $query->where('check_in', '<=', $check_out)
                      ->where('check_out', '>=', $check_in);
            })
            ->sum('persons');

            return $room->places - $occupiedPlaces;      
    }

   public function create(array $data)
    {
        
        $validator = Validator::make($data, [
            'hotel_id' => 'required',
            'room_id' => 'required',
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'persons' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $room = RoomModel::findOrFail($data['room_id']);
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

        $requestedPlaces = $data['persons'];
        
        $avaliablePlaces = $this->avaliablePlaces($room, $check_in, $check_out);

        if ($requestedPlaces > $avaliablePlaces) {
            throw new \Exception('Er zijn weinig plekken');
        }

        $totalPrice = $nights * $requestedPlaces * $room->price;

        return BookingModel::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'check_in' => $check_in->toDateString(),
            'check_out' => $check_out->toDateString(),
            'persons' => $requestedPlaces,
            'total_price' => $totalPrice,
            'places' => $requestedPlaces,
        ]);
    }

    public function plus(array $data){

        $room = RoomModel::findOrFail($data['room_id']);
        $check_in = Carbon::parse($data['check_in']);
        $check_out = Carbon::parse($data['check_out']);
        $nights = $check_in->diffInDays($check_out);
        
        $persons = session('persons', $data['persons']);
        $persons++;
        
        $today = Carbon::today(); 

        if ($nights < 1){
        $nights = 1;
    }

        $TotalPrice = $nights * $persons * $room->price;

        session([
        'persons' => $persons, 
        'total_price' => $TotalPrice,
        'check_in' => $check_in->format('Y-m-d'),
        'check_out' => $check_out->format('Y-m-d'),
        ]);
    }

    public function min(array $data){

        $room = RoomModel::findOrFail($data['room_id']);
        $check_in = Carbon::parse($data['check_in']);
        $check_out = Carbon::parse($data['check_out']);
        $nights = $check_in->diffInDays($check_out);
        
        $persons = session('persons', $data['persons']);
        $persons--;
        
        $today = Carbon::today(); 

        if ($nights < 1){
        $nights = 1;
    }

        $TotalPrice = $nights * $persons * $room->price;

        session([
        'persons' => $persons, 
        'total_price' => $TotalPrice,
        'check_in' => $check_in->format('Y-m-d'),
        'check_out' => $check_out->format('Y-m-d'),
        ]);
    }
}
