<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">
    <title>Reviews</title>
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
<h class="hotel">{{ $hotel->name }}</h>
</div>
 @if($reviews->isEmpty())
 <div class = "div_no_message">
<h class = "no_message">No comments<h>
</div>
@endif

 @foreach($reviews as $review)

    <div class = "review">
        
      <p class="user_name">{{ $review->user->name }}</p>
      <div class = "flex_reviews">
      <p>Rating: {{ $review->rating }}</p>
      <p>{{ $review->created_at->format('Y-m-d') }}</p>
      </div>
      <p>{{ $review->comment }}</p>

@if(auth()->user()?->is_admin || auth()->user()?->id === $review->user_id)
    <form action = "{{ route('review_delete', $review->id) }}" method = "POST">
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