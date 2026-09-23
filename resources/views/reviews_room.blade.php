<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">
    <title>Reviews: {{ $room->room_number}} </title>
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
<h class="hotel">{{ $room->room_number}}</h>
</div>
 @if($reviews->isEmpty())
 <div class = "div_no_message">
<h class = "no_message">No comments<h>
</div>
@endif

 @foreach($reviews as $review)

    <div class = "review">

      

      <p class="user_name">{{ $review->user->name }}</p>
      <p  class ="stars"> @foreach($reviews as $review)
     
     @php
        $rating = $review->rating;
        $fullStars = floor($rating);
        $emptyStars = 5 - $fullStars;
    @endphp
        @for ($i = 1; $i <= $fullStars; $i++)
            <i class="fa-solid fa-star" style="color: gold;"></i>
            @endfor

         @for ($i = 1; $i <= $emptyStars; $i++)
            <i class="fa-regular fa-star" style="color: gold;"></i>
    @endfor</p>
      <p>{{ $review->comment }}</p>
      <p class="review_date">{{ $review->created_at->format('Y-m-d') }}</p>

@if(auth()->user()?->is_admin || auth()->user()?->id === $review->user_id)
    <form action = "{{ route('review_room_delete', $review->id) }}" method = "POST">
    @csrf
    @method('DELETE')
    <button type = "submit">Delete</button>
</form>
@endif
    </div>
</div> 
@endforeach
</div>
@endforeach
</div>

<form action = "{{ route('review_room_store', ['room_id' => $room->id] )}}" method = "POST" class="form">
        @csrf
       <input type="hidden" name = "room_id" value="{{$room->id}}">
      <div class="li">    
 <textarea type="text" name = "comment" required class="input_comment" placeholder ="Type hier..."></textarea>
     @error('comment')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
</div>

 
 <div class="rating_center">
 <select name = "rating" required class="input_rating"> 
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
</select>
     @error('rating')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror

<button type = "submit" class="button">Review</button>
    

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif


</div>
</div>
   

</script>
</body>
</html>