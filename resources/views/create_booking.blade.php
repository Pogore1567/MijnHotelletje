<!DOCTYPE html>
<html lang="ru">
<head>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">

      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">

    <title>Booking: {{$room->room_number}}</title>
</head>
<body>
    <h class="price">Totaal: €{{ number_format(session('total_price', $room->price), 2, ',', '') }}</h>

    <form action = "{{ route('booking_store')}}" method = "POST" class="form">
        @csrf
        
        <div>
        <input type="hidden" name = "room_id" value="{{$room->id}}">
     <div>
        <div class="li">

     <div class="input_name"> <p>Checkin</p> </div>
    <input type="date" name = "check_in" required value="{{  session('check_in') }}" autocomplete="off" onchange="this.form.formAction='{{ route('plus') }}';" class="user_data">
  @error('check_in')
    <h2>{{ $message }}</h2>
  @enderror
</div>
       <div class="li">
    <div class="input_name"> <p>Checkout</p> </div>
    <input type="date" name = "check_out" required value="{{ session('check_out') }}" autocomplete="off" onchange="this.form.formAction='{{ route('plus') }}';" class="user_data">
 @error('check_out')
    <h2>{{ $message }}</h2>
    @enderror
</div>
       <div class="li">
      <div class="input_name"> <p>Persons</p> </div>
       <li class="quantity">
    <input type="number" name = "persons" required min = "1" value="{{ session('persons', 1) }}" class="input_persons" onchange="this.form.formAction='{{ route('plus') }}' ">
      <div class="controllers">
       <button type = "submit" formaction= "{{ route('plus') }}"  class="plus">+</button>
       <button type = "submit" formaction= "{{ route('min') }}"  class="min">-</button>
      <div>
</li>
</div>

    </div>
      
      <li class="button_center">
     <button type = "button" class="terug_button" onclick="window.location.href= '{{ route('hotels')}}' ">Terug</button>
     <button type = "submit" class="booking_button">Booking</button>
      </li>
    </ul>
    </div>
  @if ($errors->any)
   @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{ $error }}
    </div>
    
@endforeach
@endif
</form>

</body>
</html>