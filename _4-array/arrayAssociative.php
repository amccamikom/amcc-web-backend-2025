<?php 

// berbeda dengan array biasa yang diakses menggunakan index numerik (0,1,2,...),
// array asosiatif menggunakan key (string) untuk mengakses nilainya
$student = [
    "name" => "John",
    "age" => 25
];

echo "My name is " . $student["name"] . " and I am " . $student["age"] . " years old."; // mengakses nilai menggunakan key string ("name" dan "age")
