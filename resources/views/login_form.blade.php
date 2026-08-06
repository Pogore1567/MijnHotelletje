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
   
 <form action = "{{ route('login')}}" method = "POST" class="login_register_form">

<div class=" form_head">
   <h class="form_name">Login</h>
</div>

<div class="ul">

<div>    
<div class="input_name"> <p>Email</p> </div>
 <input type="email" name = "email" required class="user_data"> 
 @error('email')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
</div>

<div>
<div class="input_name"> <p>Password</p> </div>
 <input type="password" name = "password" required class="user_data">
 @error('password')
    <h2 class="error_message">{{ $message }}</h2>
    @enderror
<p class="admin_login"><a href = "{{ route('show_admin_login')}}">Inloggen als admin</a></p> 
</div>


<div class="button_center_login">
    <button type = "submit" class="booking_button">Login</button>
    <button type = "button" class="terug_button" onclick="window.location.href= '{{ route('show_registration') }}' ">Registration</button>
</div>

</form>

</body>
</html>