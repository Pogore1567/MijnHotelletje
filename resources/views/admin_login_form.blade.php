<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('css/MH.png') }}">
    <title>Login</title>
</head>
<body>
   
 <form action = "{{ route('admin')}}" method = "POST" class="login_register_form">
<div class="flex_1">
   <h class="form_name">Login</h>
</div>
<div class="flex_2">

<div class="ul">

<div class="li">    
<div class="input_name"> <p>Email</p> </div>
 <input type="email" name = "email" required class="user_data"> 
  @error('email')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
</div>

<div class="li">
<div class="input_name"> <p>Password</p> </div>
 <input type="password" name = "password" required class="user_data">
  @error('password')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
</div>

<div class="li">
    <div class="input_name"><p>Admin Password</p> </div>
    <input type="password" name = "admin_password" required class="user_data">
     @error('admin_password')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
</div>


<li class="button_center_login">
    <button type = "button" class="terug_button" onclick="window.location.href= '{{ route('hotels')}}' ">Terug</button>
    <button type = "submit" class="booking_button">Login</button>
    
</li>
</div>
</div>
</form>

</body>

</html>