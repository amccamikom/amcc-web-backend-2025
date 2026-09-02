# Praktikum Docker — Machine Health Monitor

## Cara menggunakan panduan

Kerjakan level secara berurutan dan buat commit kecil setelah acceptance criteria level tersebut terpenuhi. Simpan hasil eksperimen yang gagal di catatan pribadi: error Docker sering menjadi bahan belajar terbaik. Panduan memberi arah, bukan konfigurasi siap salin.

## Level 1 — Menjalankan starter secara lokal

### Tujuan

Memahami alur React → Express → FastAPI dan memastikan baseline aplikasi berfungsi sebelum Docker diperkenalkan.

### Tugas

1. Install dependency Node.js dan Python sesuai README.
2. Jalankan ketiga service di terminal terpisah.
3. Periksa endpoint health dan `/api/status`.
4. Kirim input normal, warning, dan critical dari UI.
5. Hentikan ML service dan amati UI serta response backend.

### Petunjuk singkat

Mulai service dari paling hilir: ML service, backend, lalu frontend. Perhatikan port dan log HTTP setiap terminal.

### Acceptance criteria

- UI dapat dibuka dan menampilkan indikator seluruh service online.
- Request dari UI menghasilkan status, risk score, rekomendasi, dan waktu pemeriksaan.
- Input kosong atau tidak valid ditolak dengan pesan yang jelas.
- `/api/status` melaporkan ML service offline ketika FastAPI dihentikan.

### Pertanyaan refleksi

- Di service mana validasi dilakukan, dan mengapa ada validasi di lebih dari satu lapisan?
- Apa nilai baseline yang perlu dijaga ketika aplikasi dipindah ke container?
- Apa yang terjadi jika salah satu service berhenti?

## Level 2 — Containerize ML service

### Tujuan

Membedakan source code, instruksi build, image, dan container melalui service Python yang kecil.

### Tugas

1. Tulis instruksi build untuk ML service.
2. Pilih base image Python yang stabil dan sesuai versi project.
3. Install dependency dari `requirements.txt` saat build image.
4. Salin source code yang diperlukan dan tentukan command Uvicorn.
5. Build image, jalankan container, dan uji `/health` serta `/predict` dari host.

### Petunjuk singkat

Perhatikan working directory, urutan copy untuk memanfaatkan build cache, binding ke `0.0.0.0`, serta perbedaan port aplikasi dan port host.

### Acceptance criteria

- Image dapat dibangun dari context yang dipilih.
- Container berjalan tanpa virtual environment host.
- Port container dapat diakses dari host.
- Response contoh tetap `WARNING` dengan risk score `65`.
- Dependency di-install saat build, bukan manual setelah container berjalan.

### Pertanyaan refleksi

- Apa perbedaan image dan container?
- Mengapa dependency sebaiknya di-install saat build image?
- Apa perbedaan `EXPOSE` dan port mapping?
- Mengapa server di dalam container perlu mendengarkan `0.0.0.0`?

## Level 3 — Containerize backend

### Tujuan

Mempelajari komunikasi antarkontainer, konfigurasi runtime, dan kegagalan asumsi `localhost`.

### Tugas

1. Tulis instruksi build backend berbasis Node.js.
2. Jalankan backend dan ML service sebagai dua container.
3. Pertama, pertahankan `ML_SERVICE_URL=http://localhost:8000` dan catat error.
4. Buat network Docker dan hubungkan kedua container.
5. Ganti hostname ML dengan nama container/network alias yang dapat di-resolve.
6. Uji timeout dengan menghentikan ML service.

### Petunjuk singkat

Setiap container memiliki network namespace sendiri. `localhost` selalu menunjuk container tempat proses tersebut berjalan. Gunakan environment variable untuk memindahkan alamat dependency tanpa mengubah source code.

### Acceptance criteria

- Backend dan ML service berjalan di container berbeda.
- Backend dapat memanggil `/health` ML service melalui network Docker.
- `/api/analyze` memberi response lengkap.
- Backend tetap memberi error terstruktur ketika ML service tidak dapat dijangkau.

### Pertanyaan refleksi

- Mengapa `localhost:8000` dari container backend tidak mengarah ke ML container?
- Apa beda port internal container dengan port yang dipublikasikan ke host?
- Mengapa alamat service tidak sebaiknya ditulis permanen di source code?

## Level 4 — Containerize frontend

### Tujuan

Memahami development container, bind mount, hot reload, dan batas konteks environment variable di browser.

### Tugas

1. Buat container frontend yang menjalankan Vite development server.
2. Publikasikan port Vite ke host.
3. Gunakan bind mount agar perubahan source terlihat tanpa rebuild penuh.
4. Pastikan directory dependency container tidak tertimpa dependency host.
5. Atur `VITE_API_BASE_URL` agar request browser dapat mencapai backend.

### Petunjuk singkat

Kode frontend berjalan di browser pengguna. Alamat backend harus dapat diakses oleh browser, bukan hanya dapat di-resolve antarcontainer. Amati pula kapan Vite membaca environment variable.

### Acceptance criteria

- UI terbuka dari browser host.
- Perubahan JSX/CSS terlihat melalui hot reload.
- UI berhasil menganalisis mesin melalui backend.
- Instalasi dependency tidak dilakukan manual di container yang sedang berjalan.

### Pertanyaan refleksi

- Mengapa frontend browser mungkin tetap memakai `localhost`, sementara backend container tidak?
- Apa perbedaan bind mount dan named volume?
- Apa risiko memakai development server untuk production?

## Level 5 — Docker Compose

### Tujuan

Mendefinisikan dan menjalankan aplikasi multi-service sebagai satu kesatuan yang repeatable.

### Tugas

1. Definisikan ketiga service dalam satu file Compose.
2. Atur build context, port, dan environment variable tiap service.
3. Gunakan service name sebagai hostname komunikasi internal.
4. Jalankan seluruh stack dengan satu perintah.
5. Periksa log semua service dan log satu service tertentu.
6. Hentikan dan buat ulang stack; pastikan hasilnya konsisten.

### Petunjuk singkat

Compose menyediakan DNS berbasis nama service pada network project. Bedakan konfigurasi yang dibutuhkan pada build time dan runtime. Hindari memasukkan credential ke file konfigurasi.

### Acceptance criteria

- Satu perintah memulai ketiga service.
- `/api/status` menunjukkan backend dan ML online.
- UI memberi hasil analisis lengkap.
- Tidak ada alamat IP container yang di-hardcode.
- Service dapat dibuat ulang tanpa langkah manual di dalam container.

### Pertanyaan refleksi

- Masalah apa yang diselesaikan Docker Compose dibanding menjalankan container satu per satu?
- Kapan urutan start belum berarti service sudah siap menerima request?
- Mengapa environment variable dibutuhkan di production?

## Level 6 — Production build

### Tujuan

Membedakan toolchain development dari artifact production dan menerapkan multi-stage build.

### Tugas

1. Buat tahap build frontend yang menghasilkan directory `dist`.
2. Buat tahap runtime terpisah menggunakan web server statis seperti Nginx.
3. Salin hanya artifact hasil build ke tahap runtime.
4. Hubungkan frontend production ke backend menggunakan strategi konfigurasi yang kalian pilih.
5. Bandingkan ukuran image dan proses yang berjalan dengan versi development.

### Petunjuk singkat

Vite dibutuhkan untuk membangun asset, tetapi tidak harus berada di runtime image. Ingat bahwa variable berawalan `VITE_` disubstitusi saat proses build.

### Acceptance criteria

- Runtime frontend tidak menjalankan Vite development server.
- Source dan dependency build yang tidak perlu tidak ada di final image.
- Browser tetap dapat melakukan flow end-to-end.
- Refresh halaman aplikasi tidak menghasilkan error server statis.

### Pertanyaan refleksi

- Mengapa frontend production tidak sebaiknya menggunakan Vite development server?
- Apa keuntungan multi-stage build?
- Apa beda build-time configuration dan runtime configuration untuk SPA?

## Level 7 — Production readiness sederhana

### Tujuan

Meningkatkan keamanan, observability, reliability, dan efisiensi stack tanpa menjadikannya terlalu kompleks.

### Tugas

1. Tambahkan health check yang menguji endpoint service yang tepat.
2. Tentukan restart policy yang sesuai.
3. Kurangi build context dengan ignore file per service.
4. Evaluasi apakah named network eksplisit diperlukan.
5. Jalankan proses dengan non-root user jika base image memungkinkan.
6. Kurangi ukuran image dan pastikan log menuju stdout/stderr.
7. Uji penghentian satu service dan proses pemulihannya.
8. Catat bagaimana konfigurasi rahasia seharusnya diberikan di production—tanpa memasukkan secret asli.

### Petunjuk singkat

Health check sebaiknya menguji kemampuan service, bukan sekadar keberadaan proses. Restart policy tidak memperbaiki error konfigurasi; ia hanya mengatur perilaku ketika proses berhenti.

### Acceptance criteria

- Status health setiap container dapat dilihat dari Docker.
- Container yang crash berperilaku sesuai restart policy.
- Image tidak memuat `.env`, virtual environment, cache, atau dependency host.
- Process utama menerima signal shutdown dan log dapat dibaca dari Docker.
- Final stack dapat dibangun ulang dari clean checkout.

### Pertanyaan refleksi

- Apa fungsi health check, dan apa bedanya dengan restart policy?
- Kapan named network diperlukan jika Compose sudah membuat network default?
- Mengapa proses non-root lebih aman?
- Apa konsekuensi log yang hanya ditulis ke file di dalam container?
- Bagaimana Docker membantu CI/CD dan deployment tanpa menjadi layanan hosting?

## Checklist kelulusan praktikum

- Seluruh source starter tetap berfungsi tanpa Docker.
- Ketiga service memiliki image sendiri.
- Compose menjalankan flow end-to-end tanpa IP hardcode.
- Setup development dan production memiliki tujuan yang jelas.
- Tidak ada secret yang tercatat di Git.
- Peserta dapat menjelaskan Dockerfile, image, container, registry, network, volume, dan Compose dengan kata-kata sendiri.
