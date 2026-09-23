<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    protected $table = 'review';
    protected $fillable = ['hotel_id', 'room_id', 'comment', 'rating', 'user_id'];

    public function hotel(){
    return $this->belongsTo(HotelModel::class, 'hotel_id'); 
}

    public function room(){
    return $this->belongsTo(RoomModel::class, 'room_id'); 
}

    public function user(){
    return $this->belongsTo(User::class); 
}
}
