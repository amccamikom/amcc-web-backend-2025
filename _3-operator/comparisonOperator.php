<?php 
  
  $angka1 = 15;
  $angka2 = 5;

  // Operator ternary ( ? : ) digunakan sebagai versi singkat dari if else
  // Format:
  // kondisi ? nilai_jika_benar : nilai_jika_salah

  // Jika $angka1 lebih besar dari $angka2, maka hasilnya "ya"
  // Jika tidak, maka hasilnya "tidak"
  $lebihBesar = $angka1 > $angka2 ? "ya" : "tidak";

  // Jika $angka1 lebih kecil dari $angka2, maka hasilnya "ya"
  // Jika tidak, maka hasilnya "tidak"
  $lebihKecil = $angka1 < $angka2 ? "ya" : "tidak";

  // Jika $angka1 sama dengan $angka2, maka hasilnya "ya"
  // Jika tidak, maka hasilnya "tidak"
  $sama = $angka1 == $angka2 ? "ya" : "tidak";

  // Menampilkan hasil perbandingan ke layar
  echo "Apakah $angka1 lebih besar daripada $angka2? " . $lebihBesar;
  echo "<br>";

  echo "Apakah $angka1 lebih kecil daripada $angka2? " . $lebihKecil;
  echo "<br>";

  echo "Apakah $angka1 sama dengan $angka2? " . $sama;