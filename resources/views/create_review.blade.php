<!DOCTYPE html>
<html lang="ru">
<head>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
       <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">

    <title>Make Review: {{$hotel->name}}</title>
</head>
<body>


    <form action = "{{ route('review_store', ['hotel_id' => $hotel->id] )}}" method = "POST" class="form">
        @csrf
        <div class="form_content">
        
     <div>
       <input type="hidden" name = "hotel_id" value="{{$hotel->id}}">

      <div class="li">    
 <div class="input_name"> <p>Comment</p></div>
 <textarea type="text" name = "comment" required class="input_comment"> </textarea>
     @error('comment')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
</div>


     <div class="li">    
 <div class="input_name"> <p>Rating</p> </div>
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
</div>
   </div>

   <li class="button_center">
    <button type = "button" class="terug_button" onclick="window.location.href= '{{ route('hotels')}}' ">Terug</button>
    <button type = "submit" class="booking_button">Review</button>
    
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

</li>

</div>
    </div>

</form>
</body>
</html>