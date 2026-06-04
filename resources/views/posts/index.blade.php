<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Catatan AMCC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>Daftar Catatan (Web Base)</h1>
    <a href="/posts/create" style="display: inline-block; margin-bottom: 15px; padding: 10px; background: #007bff; color: white; text-decoration: none;">+ Tambah Catatan</a>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    <hr>

    @if($posts->isEmpty())
        <p>Belum ada catatan nih. Ayo bikin data baru</p>
    @else
        <ul>
            <div style="margin-top: 30px; display: flex;">
                {{ $posts->links() }}
            </div>
            @foreach($posts as $post)
                <li style="margin-bottom: 15px;">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->content }}</p>
                    <small>
                        Ditulis oleh: <strong>{{ $post->user->name }}</strong><br>
                        Dibuat pada: {{ $post->created_at->format('d M Y') }}
                    </small>
                </li>
            @endforeach
        </ul>
    @endif

</body>
</html>
