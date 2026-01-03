<?php
// --- STUDI KASUS: DATA TRANSAKSI E-COMMERCE (Nested Array) ---
// Ini struktur yang bakal sering dilihat kalau mainan API/Backend (JSON)

$transaksi = [
    [
        "id" => "TRX-001",
        "user" => "Ucup",
        "items" => [ // Array 3 Dimensi (Array di dalam Array di dalam Array)
            "Laptop ROG", 
            "Mouse Gaming"
        ]
    ],
    [
        "id" => "TRX-002",
        "user" => "Siti",
        "items" => [
            "Iphone 15", 
            "Charger Original"
        ]
    ]
];

// Cara baca data bertingkat:
// 1. Ambil transaksi pertama (Ucup) -> index [0]
// 2. Masuk ke daftar belanjaan (items) -> key ["items"]
// 3. Ambil barang pertamanya -> index [0]

echo  $transaksi[1]["user"][0];

// Tips:
// Di Backend, kita jarang pakai angka [0][0][0] untuk logika bisnis.
// Kita lebih sering campur antara Angka (untuk list) dan String (untuk properti).