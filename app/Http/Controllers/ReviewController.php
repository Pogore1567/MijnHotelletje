<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelModel;
use App\Models\ReviewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
     public function index(Request $request){
        
        $hotelId = $request->input('hotel_id');
        $hotel = HotelModel::findOrFail($hotelId);

        $reviews = ReviewModel::with('user')->where('hotel_id', $hotelId)->latest()->get();

        return view('reviews', compact('reviews', 'hotel'));
    }

    public function create($hotel_id){

         $hotel = HotelModel::findOrFail($hotel_id);

        return view('create_review', ['hotel' => $hotel] );
    }

     public function store(Request $request, $hotel_id){
        
    $validator = Validator::make($request->all(), [
        'hotel_id' => 'required',
        'comment' => 'nullable',
        'rating' => 'required',
        ],

        [
        'rating.required' => 'Rating: Must have',
        'comment.required' => 'Raiting: Must have',
        'hotel_id.required' => 'Raiting: Must have',
        ] 
    );

    if($validator->fails()){
        return redirect()->back()->
        withErrors($validator);
    }

    $review = $validator->validated();

    $review['user_id'] = Auth::id();

    $alreadyCommented = ReviewModel::where('hotel_id', $hotel_id)
    ->where('user_id', auth()->id())
    ->exists();

    if ($alreadyCommented) {
        return back()->with('error', 'U heeft review al vroeger geschreven');
    }

    ReviewModel::create($review);

        return redirect()->route('reviews', ['hotel_id' => $review['hotel_id'] ] )->with('success', 'Review toegevoegd!');
    }

    public function destroy($id){
        $review = ReviewModel::findOrFail($id);
        $hotel_id = $review->hotel_id;
        $review->delete();
        return redirect()->route('reviews', ['hotel_id' => $hotel_id])->with('success', 'review is deleted');
    }
}
