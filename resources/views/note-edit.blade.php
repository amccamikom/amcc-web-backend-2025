<!DOCTYPE html>
<html>
<head><title>Edit Catatan</title></head>
<body>
    <h1>Edit Catatan ID: {{ $id }}</h1>

    <!-- SIMULASI PUT (UPDATE) -->
    <form action="/notes/{{ $id }}" method="POST">
        @csrf
        @method('PUT') <!-- Ngakalin browser jadi PUT -->
        <button type="submit">Update Catatan</button>
    </form>
    <hr>

    <!-- SIMULASI DELETE (HAPUS) -->
    <form action="/notes/{{ $id }}" method="POST">
        @csrf
        @method('DELETE') <!-- Ngakalin browser jadi DELETE -->
        <button type="submit" style="color: red;">Hapus Catatan Ini</button>
    </form>
</body>
</html>
