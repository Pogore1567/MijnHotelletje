<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealModel extends Model
{
    protected $table = 'meal';
    protected $fillable = ['meal', 'hotel_id'];

    
    public function meal(){
    return $this->belongsTo(HotelModel::class, 'hotel_id');
    }
}
