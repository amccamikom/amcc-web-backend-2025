<?php

// variabelnya ada, tapi benar-benar tidak punya nilai
$empty = null;

// Variabel $kosong berisi string kosong (sebenarnya ada isinya, yaitu spasi)
$kosong = " ";

// Variabel $nol berisi angka 0
$nol = 0;

echo $empty;
echo "<br>";
echo $kosong;
echo "<br>";
echo $nol;


$nama = "Budi";
$fotoProfil = NULL; // Belum diupload

echo "Nama: " . $nama . "";

if ($fotoProfil === NULL) {
    echo "Foto Profil: Belum diupload";
} else {
    echo "Foto Profil: " . $fotoProfil;
}