<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['user_id', 'room_id', 'check_in', 'check_out', 'total_price', 'persons', 'places'];

    protected $casts = ['check_in' => 'date', 'check_out' => 'date'];
    
    public function room(){
    return $this->belongsTo(RoomModel::class, 'room_id');
   }


   public function user(){
    return $this->belongsTo(User::class, 'user_id'); 
   }
}



