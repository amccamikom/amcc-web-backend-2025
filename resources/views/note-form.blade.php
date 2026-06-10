<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bikin Catatan Baru</title>
</head>
<body>
    <h1>Form Bikin Catatan</h1>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>


    @endif

    <form action="/notes?role={{ request('role') }}" method="POST">

        @csrf


        <label>Judul Catatan:</label><br>
        <input type="text" name="title"><br><br>


        <label>Isi Catatan:</label><br>
        <textarea name="content"></textarea><br><br>


        <button type="submit">Simpan Catatan</button>
    </form>
</body>
</html>
