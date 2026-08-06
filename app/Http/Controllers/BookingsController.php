<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\HotelModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Services\BookingService;

class BookingsController extends Controller
{
    public function index(){;

     if(auth()->user()?->is_admin){
        $bookings = BookingModel::with('hotel')->get();
     }elseif(auth()->check()){
        $bookings = BookingModel::with('hotel')->where('user_id', auth()->id())->get();
     } else{
        return redirect()->route('show_login');
     }
       
     return view('bookings', compact('bookings'));
    }
 

    public function create(Request $request, $hotel_id,){

         $hotel = HotelModel::findOrFail($hotel_id);
         if (!$request->filled('check_in') && !session()->has('persons')) {
        session()->forget(['check_in', 'check_out', 'persons', 'total_price']);
    }
         $TotalPrice = $hotel->price;

        return view('create_booking', ['hotel' => $hotel, 'total_price'=> $TotalPrice] );
    }
    public function store(Request $request, BookingService $service){
        

    $validator = Validator::make($request->all(), [
        'hotel_id' => 'required',
        'check_in'  => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'persons' => 'required',
        ],

        [
        'hotel_id.required' => 'Must have',
        'check_in.required' => 'Must have',
        'check_out.required' => 'Must have',
        'persons.required' => 'Must have' ,
        'check_in.after_or_equal' => 'Kan niet vroeger dan vandaag zijn!',
        'check_out.after' => 'Kan niet vroeger dan de aankomstdatum zijn!',
         ]);

    
    if($validator->fails()){
        return redirect()->back()->withErrors($validator);
    }

    try {
    $service->create($validator->validated()); 
    } catch (\Exception $e) {
    return back()->withInput()->with('error', $e->getMessage());
    }

        return redirect()->route('bookings');
    }
    
    public function plus(Request $request, BookingService $service){

    $service->plus([
        'hotel_id'  => $request->hotel_id,
        'check_in'  => $request->check_in,
        'check_out' => $request->check_out,
        'persons'   => $request->persons,
    ]);

        return back();
    }

    public function min(Request $request, BookingService $service){

    $service->min([
        'hotel_id'  => $request->hotel_id,
        'check_in'  => $request->check_in,
        'check_out' => $request->check_out,
        'persons'   => $request->persons,
    ]);

        return back();
    }

    public function destroy($id){
    $booking = BookingModel::findOrFail($id);

    if(auth()->user()->is_admin || auth()->user()?->id === Auth::id())
        
        $booking->delete();
        return redirect()->route('bookings')->with('success', 'booking is deleted');
    }
}
