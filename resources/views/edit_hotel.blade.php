<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/hotel.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <title>Edit Hotel: {{$hotel->name}}</title>
</head>
<body>

<form action = "{{ route('hotel_update', $hotel->id) }}" method = "POST" enctype="multipart/form-data" >
    @csrf
    <input type="hidden" name="hotel_id" value="$hotel->id">
    <label>Name</label>
    <input type="text" name = "name" required value="{{ $hotel->name }}">
    <label>Adres</label>
    <input type="text" name = "adres" required value="{{ $hotel->adres }}">
    <label>Description</label>
    <input type="text" name = "description" required value="{{ $hotel->description }}">
    <label>Image</label>
    <input type="file" name = "image" id = "image" accept="image/*" value="{{ $hotel->image }}">
    
    <button type = "submit">Edit</button>
</form>

</body>
</html>