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

    <title>Hotels</title>
</head>

<body>
  <button class="open_button" onclick="openNav()">&#9776;</button>

<div class="weather_div">

    <h2 class="weather_atributes">{{ $city }}</h2>

    <form action="/hotels" method="GET" class="input_weather">

        <input type="text" id="city" name="city" class="city_input" placeholder="City">
        <button type="submit" class = "city_button">Get</button>

    </form>

    @if(isset($weather) && isset($weather['main']))

        <div class="weather_data">
           <p class="weather_atributes" id ="live-clock">🕑{{ $time }}</p>
            <p class="weather_atributes">🌡️{{ number_format($weather['main']['temp']) }} °C</p>
            <p class="weather_atributes">💧{{$weather['main']['humidity'] }}%</p>
            <p class="weather_atributes">{{ match($weather['weather'][0]['main'] ?? '') {
        'Clear'        => '☀️',
        'Clouds'       => '☁️',
        'Rain', 'Drizzle', 'very heavy rain', 'heavy intensity rain', 'moderate rain' , 'light rain'=> '🌧️',
        'Thunderstorm' => '🌩️',
        'Snow'         => '❄️',
         default => '🌫️'
        
          } }}
        {{ $weather['weather'][0]['description'] }}
        </p>
        </div>

        @else
            <p>Error: Could not retrieve weather data.</p>
        @endif


    <?php if (isset($error)) : ?>
        <p style="color: red;">{{ $error }}</p>
    <?php endif; ?>
    </div>

  <div class="head_hotels">

<form action="{{ route('hotels') }}" method="GET">
    <div class = "input_hotels">

      <input type="text" name="search_hotel" class="search_hotels" placeholder="Hotel name">
      <div class ="search_actions">
      <button type="submit" class="button_search"><img src ="{{ asset('css/search.png') }}" class = "search_icon"></button>
     </div> 
     
    </div>
    </form>

  </div>
  
  @if ($hotels->isEmpty())
    <p class="no_results">Geen hotels gevonden</p>
    @endif

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

    @foreach($hotels as $hotel)
    
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
      <p class="hotel_description"><a href = "{{ route('hotel', $hotel->id) }}" class="links">More</a></p>

      <div class="actions">
  
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
@if(auth()->user()?->is_admin)
      <form action = "{{ route('hotel_delete', $hotel->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
 <form action = "{{ route('show_hotel_update', $hotel->id) }}" method = "GET">
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
 <form action = "{{ route('hotel_store') }}" method = "POST" enctype="multipart/form-data" >
    @csrf
    <label>Name</label>
    <input type="text" name = "name" required>
    <label>Adres</label>
    <input type="text" name = "adres" required>
    <label>Description</label>
    <input type="text" name = "description" required>
    <label>Image</label>
    <input type="file" name = "image" id = "image" accept="image/*">
    
    <button type = "submit">Add</button>
</form>
</div>
@endif


</body>

</html>