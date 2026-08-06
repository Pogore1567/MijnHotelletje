<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MealModel;

class MealController extends Controller
{
    public function store(Request $request){
      
    $validator = Validator::make($request->all(), [
        'hotel_id' => 'required',
        'meal' => 'required'
    ],

    [
        'meal.required' => 'Must have'
    ]
    );

    if ($validator->fails()){
        return redirect()->route('hotel')->withErrors($validator);
    }

    $validated = $validator->validated();
    
    MealModel::create($validated);

      return redirect()->back()->with('success', 'Meal is toegevoegd');
    }

    public function edit(Request $request){
      
    $validator = Validator::make($request->all(), [

        'meal' => 'required'
    ],

    [
        'meal.required' => 'Must have'
    ]
    );

    if ($validator->fails()){
        return redirect()->route('hotel')->withErrors($validator);
    }

    $validated = $validator->validated();
    
    MealModel::where('id', $id)->update([
        'meal' => $validated['meal']
    ]);

      return redirect()->back()->with('success', 'Meal is geupdated');
    }

    public function destroy($id){
        $meal = MealModel::findOrFail($id);
        $meal->delete();

        return redirect()->back()->with('success', 'Meal is verwijderd');
    }
}
