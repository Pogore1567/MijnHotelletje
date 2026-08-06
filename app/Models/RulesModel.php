<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RulesModel extends Model
{
    protected $table = 'rules';
    protected $fillable = ['rule', 'hotel_id'];

    
    public function rules(){
    return $this->belongsTo(HotelModel::class, 'hotel_id');
    }
}
