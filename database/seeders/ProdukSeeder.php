<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('produks')->insert([
                'nama_produk' => "Produk Ke-$i",
                'slug' => "produk-ke-$i",
                'harga' => rand(10000, 500000),
                'stok' => rand(1, 100),
                'deskripsi' => "Deskripsi untuk produk ke-$i",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
