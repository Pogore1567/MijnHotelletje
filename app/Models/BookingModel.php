<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['user_id', 'hotel_id', 'check_in', 'check_out', 'total_price', 'persons', 'places'];

    protected $casts = ['check_in' => 'date', 'check_out' => 'date'];
    
    public function hotel(){
    return $this->belongsTo(HotelModel::class, 'hotel_id');
   }

   public function user(){
    return $this->belongsTo(User::class, 'user_id'); 
   }
}



