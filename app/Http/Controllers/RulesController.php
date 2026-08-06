<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RulesModel;

class RulesController extends Controller
{
     public function store(Request $request){
      
    $validator = Validator::make($request->all(), [
        'hotel_id' => 'required',
        'rule' => 'required'
    ],

    [
        'rule.required' => 'Must have'
    ]
    );

    if ($validator->fails()){
        return redirect()->route('hotel')->withErrors($validator);
    }

    $validated = $validator->validated();
    
    RulesModel::create($validated);

      return redirect()->back()->with('success', 'Rule is toegevoegd');
    }

    public function edit(Request $request){
      
    $validator = Validator::make($request->all(), [

        'rule' => 'required'
    ],

    [
        'rule.required' => 'Must have'
    ]
    );

    if ($validator->fails()){
        return redirect()->route('hotel')->withErrors($validator);
    }

    $validated = $validator->validated();
    
    MealModel::where('id', $id)->update([
        'rule' => $validated['rule']
    ]);

      return redirect()->back()->with('success', 'Rule is geupdated');
    }

    public function destroy($id){
        $rule = MealModel::findOrFail($id);
        $rule->delete();

        return redirect()->back()->with('success', 'Rule is verwijderd');
    }
}
