<?php

// BUILD IN FUNCTION
// $paragraf = "Haloo semuanyaa, selamat pagii. Semangatt belajar semuanyaaa";

// echo strlen($paragraf);

// $playlist = ["Tarot", "Kalibata 2012", "Sepiring Berdua"];

// var_dump($playlist);

// array_push($playlist, "Balonku ada lima");

// var_dump($playlist);

// USER DEFINE FUNCTION

// function bunyikan_bel() {
//     echo "Tonnggg.. Tongg.. TOngg.... <br>";
// }


// function bunyikan_bel_2() {
//     return "Tonnggg.. Tongg.. TOngg.... <br>";
// }

// $bunyikanBel = bunyikan_bel_2();

// echo $bunyikanBel;

// FUNGSI DENGAN PARAMETER

// function buat_jus($buah) {
//     echo "Brrrrmmmmmmmm... Jus " . $buah . ' siap disajikan <br>'; 
// }

// buat_jus("Mangga");
// buat_jus("Pisang");

// FUNGSI DENGAN RETURN VALUE
// function hitung_total($jumlah, $harga_satuan) {
//     $total = $jumlah * $harga_satuan;

//     return $total;
// }

// $tagihan = hitung_total(3, 15000);
// echo "Silahkan bayar sebesar: Rp. " . number_format($tagihan);

// Fungsi Rekursif
// function hitung_mundur($angka) {
//     if($angka == 0) {
//         echo "DUUARRR ROKETT MELUNCURRRRR";
//         return;
//     }

//     echo $angka . "....... <br>";
//     hitung_mundur($angka - 1);
// }

// hitung_mundur(3);