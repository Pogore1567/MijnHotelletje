<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/hotel.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">

    <title>{{ $room->room_number }}</title>
</head>
<body>
   @inject('bookingService', 'App\Services\BookingService')

<button class="open_button" onclick="openNav()">&#9776;</button>

<div id="header" class="header">
<a href="javascript:void(0)" class="close_button" onclick="closeNav()">&times;</a>
<div class="header_options">
<a href="{{ route('hotels') }}">Hotels</a>
<a href="">Over Ons</a>
<a href="">Contact</a>
@if(auth()->user()?->is_admin) 
<a href="{{ route('bookings') }}">Bookings</a>
@else
<a href="{{ route('bookings') }}">Mijn Bookings</a>
@endif

@if(auth()->check()) 
<form action="{{ route('logout') }}" method="POST">
  @csrf
    <button type="submit" class = "logout_button">Logout</a>
     </div> 
    </form>

   @else 
<a href="{{ route('login') }}">Login</a>
  
  @endif
</div>
</div>
  <div class="content">

    
    <div class="hotel_card">
      
      <div class="image">
     <img src="{{ asset('storage/' . $room->image) }}" class="hotel_image">
    </div>
       <div class="description">
      <p class="hotel_name">{{ $room->room_number }}</p>
     <div class = "flex_reviews">
      <p class="hotel_adress"> 
        
      @php
        $rating = $room->reviews_avg_rating;
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;
    @endphp
        @for ($i = 1; $i <= $fullStars; $i++)
            <i class="fa-solid fa-star" style="color: gold;"></i>
            @endfor
          
         @if ($halfStar )  
            <i class="fa-solid fa-star-half-stroke " style="color: gold;"></i>
         @endif

           @for ($i = 1; $i <= $emptyStars; $i++)
            <i class="fa-regular fa-star" style="color: gold;"></i>
    @endfor </p>  

     </div>
      <p class="hotel_description">{{ $room->description }}</p>
      <p>Avaliable seats: {{ $bookingService->avaliablePlaces($room, request('check_in'), request('check_out') ) }}</p>
        <li class="button_center">
          
      <form action = "{{ route('booking_create', ['room_id' => $room->id] ) }}" method = "GET">
    @csrf
    <button type = "submit" class="booking_button">Booking</button>
     </form>

   <form action = "{{ route('reviews_rooms', ['room_id' => $room->id] ) }}" method = "GET">
    @csrf
    <input type="hidden" name="room_id" value= "{{ $room->id }}">
    <button type = "submit" class="booking_button">Review</button>
</form>
       </li>
       </div>

    </div>
</div>


</body>
</html>