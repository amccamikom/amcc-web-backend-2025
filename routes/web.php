<?php

use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route dengan clouse
Route::get('/halo', function () {
    return "Halo, ini adalah route dengan clouse";
});
// Route dengan controller
Route::get('/produk', [ProdukController::class, 'index']);
// Route dengan parameter
Route::get('/kamar/{nomor}', function ($nomor) {
    return "Kamar nomor: $nomor";
});
// Route dengan parameter opsional
Route::get('/pesan/{tambahan?}', function ($tambahan = 'Tidak ada tambahan') {
    return "Pesan kamar sedang di proses dengan: $tambahan";
});
