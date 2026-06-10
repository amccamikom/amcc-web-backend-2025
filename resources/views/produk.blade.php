<h1>Ini adalah list produk saya</h1>
<ul>
    @foreach ($produks as $produk)
        <li>{{ $produk->nama_produk }}</li>
    @endforeach
</ul>
