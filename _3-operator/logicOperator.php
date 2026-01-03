<?php
$a = true;
$b = false;

// AND
echo ($a && $b) ? "Ya" : "Tidak";
echo "<br>";

// OR
echo ($a || $b) ? "Ya" : "Tidak";
echo "<br>";

// NOT
echo (!$a) ? "Ya" : "Tidak";
echo "<br>";

// XOR 
echo ($a xor $b) ? "Ya" : "Tidak";

// contoh penggunaan pada login menggunakan logika AND (&&)
$username = "admin";
$pwd = "123";

if($username == "admin" && $pwd == "123"){ // logika AND kita gunakan disini untuk memastikan kedua kondisi terpenuhi
    echo "login anda berhasil";
}else{
    echo "maaf password atau username salah";
}