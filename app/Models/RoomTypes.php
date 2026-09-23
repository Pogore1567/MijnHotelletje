<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTypes
{
     public static function all():array {
        return [
        
        'econom' => 'Econom',
        'standard' => 'Standard',
        'superior' => 'Superior',
        'studio' => 'Studio',
        'deluxe' => 'Deluxe',
        'junior_suite' => 'Junior Suite',
        'suite' => 'Suite',
        'apartment' => 'Apartment',
        'business_suite' => 'Business Suite',
        'royal_suite' => 'Royal Suite'

        ];
     }
}
