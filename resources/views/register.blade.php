<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <form action="/user" method="POST">
        @csrf
        <label for="name">NAMA: </label><input type="text" name="name"><br>
        <label for="name">EMAIL: </label><input type="text" name="email"><br>
        <label for="name">No HP: </label><input type="text" name="no_telp"><br>
        <label for="name">ALAMAT: </label><input type="text" name="alamat"><br>
        <button type="submit">REGISTER</button>
    </form>
</body>
</html>