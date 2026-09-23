<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/hotels.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
       <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">
   <title>Rooms</title>     
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

</button> 

</div>
</div>
  </head> 

   

<div class="head_rooms">

<form action="{{ route('rooms') }}" method="GET">
   <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

    <div class = "input_rooms">
      <input type="text" name="room_number" class="search_rooms" placeholder="Room Number">

      <div class ="search_actions"> 
        <select name="room_type" class="select">
        <option value= "">All types </option>

        @foreach(\App\Models\RoomTypes::all() as $value => $name)
        <option  value="{{ $value }}">{{ $name }} </option>
        @endforeach
      </select>
      <button type="submit" class="button_search"><img src ="{{ asset('css/search.png') }}" class = "search_icon"></button>

     </div> 
    </div>
    </form>
  </div>



<body>
 

</div>
</div>





  <div class="content">

    @foreach($rooms as $room)

    @inject('bookingService', 'App\Services\BookingService')
    
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
      <p class="hotel_description"><a href = "{{ route('room', $room->id) }}" class="links">More</a></p>
       <p>Avaliable seats: {{ $bookingService->avaliablePlaces($room, request('check_in'), request('check_out') ) }}</p>
      <div class="actions">
  
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

@if(auth()->user()?->is_admin)
      <form action = "{{ route('review_room_delete', $room->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
 <form action = "{{ route('show_room_update', $room->id) }}" method = "GET">
    @csrf
    <button type = "submit">Edit</button>
</form>
@endif
       </div>

    </div>
    @endforeach
</div>
@if(auth()->user()?->is_admin)
<div class= "admin_create">
 <form action = "{{ route('room_store', ['hotel_id' => $hotel->id]) }}" method = "POST" enctype="multipart/form-data" >
    @csrf
    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
    <label>Name</label>
    <input type="text" name = "room_number" required>
    <label>Type</label>
     <select name="type"reruired>
        <option value= "">All types </option>

        @foreach(\App\Models\RoomTypes::all() as $value => $name)
        <option  value="{{ $value }}">{{ $name }} </option>
        @endforeach
      </select>
    <label>Description</label>
    <input type="text" name = "description" required>
    <label>Places</label>
    <input type="number" name = "places" required min = "0" step="1">
    <label>Price</label>
    <input type="decimal" name = "price" required min = "0" step="0.01">
    <label>Image</label>
    <input type="file" name = "image" id = "image" accept="image/*">
    
    <button type = "submit">Add</button>
</form>
</div>
@endif

</body>

</html>