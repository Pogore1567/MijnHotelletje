<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/hotel.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <title>Edit Room: $room->room_number</title>
</head>
<body>

 <form action = "{{ route('room_update', $room->id) }}" method = "POST" enctype="multipart/form-data" >
    @csrf
    <input type="hidden" name="room_id" value="$room->id">
    <label>Name</label>
    <input type="text" name = "room_number" required>
    <label>Type</label>
     <select name="type"reruired>
        <option value= "">All types </option>

        @foreach(\App\Models\RoomTypes::all() as $value => $name)
        <option  value="{{ $value }}">{{ $name }} </option>
        @endforeach
      </select>
    <label>Description</label>
    <input type="text" name = "description" required>
    <label>Places</label>
    <input type="number" name = "places" required min = "0" step="1">
    <label>Price</label>
    <input type="decimal" name = "price" required min = "0" step="0.01">
    <label>Image</label>
    <input type="file" name = "image" id = "image" accept="image/*">
    
    <button type = "submit">Edit</button>
</form>

</body>
</html>