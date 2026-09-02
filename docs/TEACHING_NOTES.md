# Teaching Notes — AMCC Docker Lab

Dokumen ini adalah panduan fasilitasi. Ia sengaja tidak menyertakan konfigurasi container siap pakai agar peserta tetap menyusun solusi sendiri.

## 1. Cerita pembuka: “Di tempatku bisa kok”

Mulai dengan cerita dua developer. Developer A mengirim source yang berjalan sempurna di laptopnya. Di laptop developer B, versi Node berbeda, Python package belum terpasang, port sudah digunakan, dan environment variable hilang. Keduanya melihat kode yang sama tetapi menjalankannya di lingkungan yang berbeda. Pertanyaannya bukan “siapa yang salah?”, melainkan “bagaimana kita mengirim lingkungan yang dapat direproduksi bersama aplikasi?”

Tampilkan starter secara lokal terlebih dahulu. Soroti tiga terminal, tiga runtime, perintah instalasi, dan asumsi port. Docker masuk sebagai alat untuk mengemas asumsi-asumsi itu menjadi sesuatu yang dapat dibangun dan dijalankan secara konsisten.

## 2. Analogi singkat

| Konsep | Analogi | Batas analogi yang perlu disebutkan |
| --- | --- | --- |
| Dockerfile | Resep masakan | Resep belum menjadi makanan; instruksi build belum menjadi image. |
| Image | Paket makanan beku tersegel | Bersifat read-only dan dapat dibuat menjadi banyak instance. |
| Container | Satu porsi yang sedang disajikan | Instance runtime dari image, memiliki proses dan isolasi sendiri. |
| Registry | Gudang/katalog paket | Menyimpan dan mendistribusikan image, bukan menjalankannya. |
| Volume | Lemari penyimpanan di luar meja kerja | Data dapat bertahan setelah container diganti. |
| Network | Ruang dan daftar kontak internal | Service dapat saling menemukan lewat nama tanpa IP hardcode. |
| Docker Compose | Denah dan koordinator satu acara | Mendefinisikan beberapa service agar dijalankan sebagai satu aplikasi. |

Tekankan bahwa analogi membantu intuisi, tetapi peserta tetap perlu melihat command dan proses nyata.

## 3. Alur demonstrasi aplikasi

1. Buka UI dan tunjukkan indikator koneksi.
2. Masukkan `Machine A`, temperatur `75`, getaran `4.2`, dan jam operasi `1200`.
3. Buka Network panel browser: React mengirim `POST /api/analyze` ke Express.
4. Tunjukkan log backend: request masuk, validasi berjalan, lalu backend memanggil FastAPI.
5. Tunjukkan log ML service dan response `WARNING`, risk score `65`.
6. Jelaskan bahwa Express menambahkan nama mesin dan timestamp sebelum mengirim response akhir.
7. Gunakan input ekstrem untuk menunjukkan hasil `CRITICAL`, lalu input ringan untuk `NORMAL`.

Gambar alur di papan: browser hanya mengenal backend; backend mengenal ML service. Ini menjadi fondasi diskusi network container.

## 4. Error yang disengaja

### Backend memakai `localhost` di dalam container

Jalankan ML service dan backend di container terpisah, tetapi biarkan URL lokal default. Minta peserta memprediksi hasil sebelum mencoba. Tunjukkan error terstruktur dan log. Jelaskan bahwa loopback berada di network namespace container backend. Arahkan peserta menggunakan DNS/nama service pada network yang sama, tanpa menuliskan konfigurasi final untuk mereka.

### Port conflict

Sebelum demo, jalankan proses aman lain pada salah satu port demo atau coba publikasikan dua container ke host port yang sama. Baca pesan error bersama. Bedakan port proses di container, port container, dan published port host. Pastikan proses pengganggu dihentikan setelah demo.

### Environment variable salah

Berikan nama host atau origin yang sengaja typo. Tunjukkan bahwa image yang sama dapat berperilaku berbeda berdasarkan konfigurasi runtime. Bedakan error CORS di browser dengan error koneksi backend-ke-ML.

### Container berhenti

Hentikan ML container saat stack berjalan. UI seharusnya tetap dapat menghubungi backend, tetapi analisis gagal dan status ML menjadi offline. Gunakan ini untuk membedakan readiness service, dependency failure, restart policy, dan graceful degradation.

## 5. Manfaat Docker saat development

- Menyamakan versi runtime dan system dependency antarpeserta.
- Membuat onboarding lebih singkat dan repeatable.
- Mengisolasi dependency antarproject.
- Menjalankan banyak service dengan topology yang mendekati production.
- Memudahkan reset ke kondisi bersih melalui rebuild/recreate.

Tetap sampaikan trade-off: build memerlukan waktu, filesystem mount dapat berbeda antar-OS, debugging network bertambah, dan Docker tidak menghilangkan kebutuhan memahami runtime aplikasi.

## 6. Manfaat pada CI/CD dan production

Dalam CI, pipeline membangun artifact yang konsisten, menguji image yang sama, memindai dependency, lalu mendorong image bertag ke registry. Pada deployment, platform mengambil image yang sudah lolos pipeline dan memberinya konfigurasi runtime. Prinsip pentingnya adalah membangun sekali lalu mempromosikan artifact yang sama, bukan membangun ulang secara berbeda di setiap server.

Di production, container membantu standardisasi packaging, rollout, rollback, isolasi proses, pembatasan resource, serta integrasi dengan orchestrator. Docker sendiri bukan seluruh strategi deployment; monitoring, secret management, backup, TLS, scaling, dan platform eksekusi tetap diperlukan.

## 7. Apa yang bukan Docker

Docker **bukan hosting**. Docker membangun dan menjalankan container; tetap dibutuhkan komputer atau platform tempat Docker/container runtime hidup.

Docker juga **bukan virtual machine penuh**. Container berbagi kernel host dan mengisolasi proses melalui fitur sistem operasi. VM biasanya membawa guest OS/kernel sendiri sehingga isolasi dan overheadnya berbeda. Jangan menyederhanakan menjadi “container selalu lebih aman atau selalu lebih baik”; kebutuhan workload menentukan pilihan.

## 8. Development vs production container

| Aspek | Development | Production |
| --- | --- | --- |
| Tujuan | Iterasi cepat dan debugging | Stabilitas, keamanan, efisiensi |
| Source | Sering di-bind mount | Umumnya sudah menjadi artifact image |
| Server frontend | Vite dev server + HMR | Web server statis untuk hasil build |
| Dependency | Dapat mencakup dev dependency | Hanya yang dibutuhkan runtime |
| Reload | Otomatis saat file berubah | Restart/rollout terkontrol |
| Image | Nyaman untuk developer | Kecil, immutable, non-root bila memungkinkan |

Gunakan perbandingan ini ketika peserta bertanya mengapa setup Level 4 tidak langsung dianggap siap production.

## 9. Checklist sebelum kelas

- Clone starter dari lokasi yang akan dipakai peserta dan ikuti README dari nol.
- Pastikan Node.js, npm, Python, Git, Docker Engine/Desktop, dan Compose tersedia.
- Jalankan test, lint, dan build project.
- Pastikan port `5173`, `3000`, dan `8000` bebas.
- Build image demo sebelumnya agar dependency download tidak bergantung penuh pada internet kelas.
- Siapkan satu set konfigurasi pengajar secara lokal, tetapi jangan masukkan ke branch starter.
- Uji flow normal, warning (`75`, `4.2`, `1200`), dan critical.
- Uji demo `localhost`, port conflict, CORS salah, dan container stop.
- Bersihkan container/network demo yang dapat membingungkan peserta.
- Pastikan terminal cukup besar, log mudah dibaca, dan browser devtools siap.
- Siapkan rencana cadangan screenshot/log bila registry atau internet bermasalah.

## 10. Pertanyaan diskusi

- Asumsi environment apa saja yang terdapat dalam starter ini?
- Kapan “works on my machine” masih dapat terjadi walaupun sudah memakai Docker?
- Mengapa container backend tidak dapat memakai `localhost` untuk ML container?
- Apa perbedaan image, container, dan registry?
- Mengapa dependency sebaiknya dipasang saat build?
- Apa perbedaan `EXPOSE` dan port mapping?
- Kapan memakai bind mount dan kapan memakai named volume?
- Apa yang sebenarnya dicek oleh health check yang baik?
- Apa yang terjadi pada request pengguna ketika salah satu service berhenti?
- Bagaimana menentukan restart policy yang tepat?
- Mengapa Vite development server tidak ideal untuk production?
- Variable frontend mana yang berlaku saat build dan mana yang dapat diubah saat runtime?
- Bagaimana log container sebaiknya dikumpulkan di production?
- Bagaimana image berpindah dari laptop developer ke CI dan production?
- Risiko apa yang tersisa setelah aplikasi berhasil dikemas ke container?

## Penutup sesi

Minta peserta menjelaskan arsitektur akhir tanpa melihat file: image apa yang dibangun, container apa yang berjalan, siapa berbicara dengan siapa, hostname apa yang digunakan, port mana yang internal/published, dan bagaimana konfigurasi diberikan. Jika mereka dapat menjelaskan alur tersebut, mereka tidak sekadar menghafal command Docker.
