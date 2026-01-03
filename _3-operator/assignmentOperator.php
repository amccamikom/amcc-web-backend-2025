<?php

// 1. int
$score = 100;

// Cara Lama
$score = $score + 100;

// versi assignment operator
$score += 100;

echo "total nilai sekarang " . $score;
echo "<br> <br>";

// 2. String
$kalimat = "Belajar PHP";

// Cara Lama
$kalimat = $kalimat . " itu seru!";

// versi assignment operator
$kalimat .= " itu seru!";

echo $kalimat;
