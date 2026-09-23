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

    <title>{{ $hotel->name }}</title>
</head>
<body>
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
     <img src="{{ asset('storage/' . $hotel->image) }}" class="hotel_image">
    </div>
       <div class="description">
      <p class="hotel_name">{{ $hotel->name }}</p>
      <p class="hotel_adress"><a href="https://www.google.com/maps/place/{{ urlencode($hotel->adres) }}" target="_blank">{{ $hotel->adres }}</a></p>
     <div class = "flex_reviews">
      <p class="hotel_adress"> 
        
      @php
        $rating = $hotel->reviews_avg_rating;
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
      <p class="hotel_description">{{ $hotel->description }}</p>
        <li class="button_center">
          
      <form action = "{{ route('rooms', ['hotel_id' => $hotel->id] ) }}" method = "GET">
    @csrf
    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
    <button type = "submit" class="booking_button">Rooms</button>
    </form>

     <form action = "{{ route('reviews_hotels', ['hotel_id' => $hotel->id] ) }}" method = "GET">
    @csrf
    <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
    <button type = "submit" class="booking_button">Review</button>
    </form>
       </li>
       </div>

    </div>
</div>

<div class="about_center">
<div class="about">

<div class="list_1">
<div class = "amenities_head">
<h class="heading">Amenity</h>
</div>
<div class = "amenities">
@foreach($hotel->amenities as $amenity)
    <div>
      <p class="option">{{ $amenity->amenity }}</p>

    <form action = "{{ route('amenity_delete', $amenity->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
 <form action = "{{ route('show_update', $hotel->id) }}" method = "GET">
    </div>
    @endforeach
</div>
</div>         
    
<div class="list_2">
<div class = "meal_head">
<h class="heading">Meal</h>
</div>
<div class = "meal">
@foreach($hotel->meals as $meal)
    <div>
      <p class="option">{{ $meal->meal }}</p>

    <form action = "{{ route('meal_delete', $meal->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
    </div>
    @endforeach
</div>
</div>      
    
<div class="list_3">
<div class = "rules_head">
<h class="heading">Rules</h>
</div>
<div class = "rules">
@foreach($hotel->rules as $rule)
    <div>
      <p class="option">{{ $rule->rule }}</p>

    <form action = "{{ route('rule_delete', $rule->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
    </div>
    @endforeach
</div>
</div>         
    
</div>
</div>

@if(auth()->user()?->is_admin)
<form action = "{{ route('amenity_store') }}" method = "POST">
    @csrf
    <input type="hidden" name = "hotel_id" value="{{$hotel->id}}">
    <label>Amenity</label>
    <input type="text" name = "amenity" required>
    <button type = "submit" class="">Add</button>
    </form>

    <form action = "{{ route('meal_store') }}" method = "POST">
    @csrf
    <input type="hidden" name = "hotel_id" value="{{$hotel->id}}">
    <label>Meal</label>
    <input type="text" name = "meal" required>
    <button type = "submit" class="">Add</button>
    </form>

    <form action = "{{ route('rule_store') }}" method = "POST">
    @csrf
    <input type="hidden" name = "hotel_id" value="{{$hotel->id}}">
    <label>Rules</label>
    <input type="text" name = "rule" required>
    <button type = "submit" class="">Add</button>
    </form>
@endif
</body>
</html>