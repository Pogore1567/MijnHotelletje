<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelModel;
use App\Models\RoomModel;
use App\Models\ReviewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
     public function index_for_hotels(Request $request){
        
        $hotelId = $request->input('hotel_id');
        $hotel = HotelModel::findOrFail($hotelId);

        $reviews = ReviewModel::with('user')->where('hotel_id', $hotelId)->latest()->get();

        return view('reviews_hotel', compact('reviews', 'hotel'));
    }


     public function store_for_hotels(Request $request, $hotel_id){
        
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

        return redirect()->back()->with('success', 'Review toegevoegd!');
    }

    public function destroy_for_hotels($id){

        $review = ReviewModel::findOrFail($id);

        $review->delete();

        return redirect()->back()->with('success', 'Review is verwjderd!');
    }





     public function index_for_rooms(Request $request){
        
        $roomId = $request->input('room_id');
        $room = RoomModel::findOrFail($roomId);

        $reviews = ReviewModel::with('user')->where('room_id', $roomId)->latest()->get();

        return view('reviews_room', compact('reviews', 'room'));
    }


     public function store_for_rooms(Request $request, $room_id){
        
    $validator = Validator::make($request->all(), [
        'room_id' => 'required',
        'comment' => 'nullable',
        'rating' => 'required',
        ],

        [
        'rating.required' => 'Rating: Must have',
        'comment.required' => 'Raiting: Must have',
        'room_id.required' => 'Raiting: Must have',
        ] 
    );

    if($validator->fails()){
        return redirect()->back()->
        withErrors($validator);
    }

    $review = $validator->validated();

    $review['user_id'] = Auth::id();

    $alreadyCommented = ReviewModel::where('room_id', $room_id)
    ->where('user_id', auth()->id())
    ->exists();

    if ($alreadyCommented) {
        return back()->with('error', 'U heeft review al vroeger geschreven');
    }

    ReviewModel::create($review);

        return redirect()->back()->with('success', 'Review toegevoegd!');
    }

    public function destroy_for_rooms($id){

        $review = ReviewModel::findOrFail($id);

        $review->delete();

        return redirect()->back()->with('success', 'Review is verwjderd!');
    }
}
