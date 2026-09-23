<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    protected $table = 'rooms';
    protected $fillable = ['hotel_id', 'room_number', 'price', 'type', 'description', 'image', 'places'];

    public function hotel(){
    return $this->belongsTo(HotelModel::class, 'hotel_id'); 
} 
    public function reviews(){
    return $this->hasMany(ReviewModel::class, 'room_id'); 
}
}
