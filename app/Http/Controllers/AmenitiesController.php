<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AmenitiesModel;

class AmenitiesController extends Controller
{

    public function store(Request $request){
      
    $validator = Validator::make($request->all(), [
        'hotel_id' => 'required',
        'amenity' => 'required'
    ],

    [
        'amenity.required' => 'Must have'
    ]
    );

    if ($validator->fails()){
        return redirect()->route('hotel')->withErrors($validator);
    }

    $validated = $validator->validated();
    
    AmenitiesModel::create($validated);

      return redirect()->back()->with('success', 'Amenity is toegevoegd');
    }

    public function edit(Request $request){
      
    $validator = Validator::make($request->all(), [

        'amenity' => 'required'
    ],

    [
        'amenity.required' => 'Must have'
    ]
    );

    if ($validator->fails()){
        return redirect()->route('hotel')->withErrors($validator);
    }

    $validated = $validator->validated();
    
    AmenitiesModel::where('id', $id)->update([
        'amenity' => $validated['amenity']
    ]);

      return redirect()->back()->with('success', 'Amenity is geupdated');
    }

    public function destroy($id){
        $amenity = AmenitiesModel::findOrFail($id);
        $amenity->delete();

        return redirect()->back()->with('success', 'Amenity is verwijderd');
    }
}
