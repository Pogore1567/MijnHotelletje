<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
       <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">
    <title>Bookings</title>
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



<div class = "content">

   
    <div class="flex_review">


<div class="hotel_center">
<h class="hotel">Bookings</h>
</div>

 @if($bookings->isEmpty())
 <div class = "div_no_message">
<h class = "no_message">No bookings<h>
</div>
@endif
 @foreach($bookings as $booking)

 @if($booking->user_id == auth()->id() || auth()->user()?->is_admin)
    <div class = "review">
        
      <p class="user_name_bookings">{{ $booking->user->name }}</p>
      <p class ="user_email">{{ $booking->user->email }}</p>
      <div class="user_attributes">
      <p>Hotel: {{ $booking->room->hotel->name }}</p>
      <p>Room: {{ $booking->room->room_number }}</p>
      <p>Persons: {{ $booking->persons }}</p>
      <p>Total price: €{{ number_format($booking->total_price, 2, ',', '') }}</p>
      </div>
@endif

@if($booking->user_id == auth()->id() || auth()->user()?->is_admin)
    <form action = "{{ route('booking_delete', $booking->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
@endif
    </div>
</div> @endforeach
</div>
   

    <script>
function openNav(){
  document.getElementById("header").style.width = "250px";
}
function closeNav(){
  document.getElementById("header").style.width = "0px";
}
</script>

</body>
</html>