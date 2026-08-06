<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AmenitiesModel extends Model
{
     protected $table = 'amenities';
    protected $fillable = ['amenity', 'hotel_id'];

    
    public function amenities(){
    return $this->belongsTo(HotelModel::class, 'hotel_id');
   }

}
