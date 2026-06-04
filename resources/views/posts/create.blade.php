<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Catatan Baru</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>Buat Catatan Baru</h1>
    <hr>

    {{-- Menampilkan pesan error validasi jika ada --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form mengarah ke route POST /posts --}}
    <form action="/posts" method="POST">
        @csrf {{-- Wajib ada untuk keamanan form di Laravel --}}

        <div style="margin-bottom: 15px;">
            <label for="title">Judul Catatan:</label><br>
            <input type="text" id="title" name="title" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="content">Isi Catatan:</label><br>
            <textarea id="content" name="content" rows="5" required style="width: 100%; padding: 8px;"></textarea>
        </div>

        <button type="submit" style="padding: 10px 20px; cursor: pointer;">Simpan Catatan</button>
        <a href="/posts" style="margin-left: 10px;">Batal</a>
    </form>

</body>
</html>
