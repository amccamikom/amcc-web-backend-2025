<?php
// PERCABANGAN IF
$hujan = false;

if($hujan) {
    echo "Bawa jas hujan, biar ngga basah";
}

// PERCABANGAN IF ELSE
$hujan = true;

if($hujan) {
    echo "Bawa jas hujan, biar ngga basah";
} else {
    echo "Tidak hujan, langsung berangkat saja";
}

// PERCABANGAN IF ELSE IF ELSE

$nilai = 81;

if($nilai >= 81) {
    echo "Nilai A";
} else if ($nilai >= 61) {
    echo "Nilai B";
} else if ($nilai >= 41) {
    echo "Nilai C";
} else if ($nilai >= 21) {
    echo "Nilai D";
} else {
    echo "E";
}

// SWITCH CASE
$makanan = "Sate Ayam";

switch($makanan) {
    case "Nasi Goreng":
        echo "Makanan yang dipilih adalah Nasi Goreng";
        break;
    case "Bakso":
        echo "Makanan yang dipilih adalah Bakso";
        break;
    case "Seblak":
        echo "Makanan yang dipilih adalah Seblak";
        break;
    default:
        echo "Makanan yang dicari tidak ada";
}

// PERCABANGAN TERNARY
// kondisi ? jikaTrue : jikaFalse;

$lulus = true;

$status = ($lulus) ? "Yeayyy Lulusss" : "Yahhh, harus semangat belajar lagi";

echo $status;