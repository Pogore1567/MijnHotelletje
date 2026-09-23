<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelModel extends Model
{
    protected $table = 'hotels';
    protected $fillable = ['name', 'adres', 'description', 'image'];
    
    public function bookings(){
    return $this->hasMany(BookingModel::class, 'hotel_id'); 
}

public function reviews(){
    return $this->hasMany(ReviewModel::class, 'hotel_id'); 
}
public function amenities(){
    return $this->hasMany(AmenitiesModel::class, 'hotel_id'); 
}
public function meals(){
    return $this->hasMany(MealModel::class, 'hotel_id'); 
}
public function rules(){
    return $this->hasMany(RulesModel::class, 'hotel_id'); 
}
public function rooms(){
    return $this->hasMany(RoomModel::class, 'hotel_id'); 
}
}


