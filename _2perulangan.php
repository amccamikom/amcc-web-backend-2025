<?php

// INCREMENT
$volume = 10;
echo "Volume sekarang ada di $volume <br>";

$volume++;
echo "Volume ketika sudah di increment $volume <br>";

// // DECREMENT

echo "Volume Sekarang belum di apa apa kan <br>";

$volume--;
echo "Volume sekarang ketika sudah dikurangi $volume <br>";

// PERULANGAN FOR LOOP

for($putaran = 1; $putaran <= 5; $putaran++) {
    echo "Saya sudah lari memutari lapangan ke-" . $putaran;
    echo "<br>";
}

// PERULANGAN WHILE LOOP
$krupuk_di_toples = 10;

while ($krupuk_di_toples > 0) {
    echo "Nyamm nyamm nyammm, makan krupukk enakk <br>";

    $krupuk_di_toples--;
}

// PERULANGAN DO WHILE
$lanjut_main = "yes"; 
$jumlah_main = 3;

do {
    echo "🎮 Sedang main game ronde ke-" . $jumlah_main . "... Seru! <br>";
    echo "💀 Yah... Nabrak pipa. GAME OVER. <br>";
    
    if ($jumlah_main < 3) {
        echo "LOG: User menekan tombol [YES] <br>";
        echo "------------------------------ <br>";
        $lanjut_main = "yes";
    } else {
        echo "LOG: User menekan tombol [NO] <br>";
        echo "------------------------------ <br>";
        $lanjut_main = "no";
    }
    
    $jumlah_main++;

} while ($lanjut_main == "yes"); 

echo "✅ Aplikasi ditutup.";

// PERULANGAN FOREACH
$playlist = ["Tarot", "Kalibata 2012", "Sepiring Berdua"];

foreach($playlist as $lagu) {
    echo "Sedang memutar: " . $lagu . "<br>";
}