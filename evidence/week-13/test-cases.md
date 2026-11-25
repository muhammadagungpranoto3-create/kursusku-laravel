# Test matrix pertemuan 13 - Search, filter, pagination Course index

Isi kolom **Actual**, **Status**, dan **Bukti** hanya setelah kasus benar-benar diuji di browser.
Catat URL yang dipakai dan jumlah data. Jangan menulis Pass sebelum diuji.

Data uji: `CourseSeeder` (8 data) + `CourseDiscoverySeeder` (24 data) = 32 kursus (open 19, closed 7, draft 6).

## Lima skenario wajib

| No | Skenario | URL / langkah | Expected | Actual | Status | Bukti |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | 0 hasil | `/courses?q=tidak-ada-xyz-999` | Empty state tampil, tanpa error | | | |
| 2 | 1 hasil | `/courses?q=UNQ-777` | Tepat 1 kursus (Kriptografi Terapan) | | | |
| 3 | Lebih dari 10 hasil | `/courses?status=open` | Halaman 1 berisi 10 data + pagination (total 19) | | | |
| 4 | Keyword dengan spasi | `/courses?q=Web Modern` | Web Modern Dasar dan Web Modern Lanjut tampil | | | |
| 5 | Filter + page 2 | `/courses?status=open`, klik halaman 2 | URL memuat `status=open&page=2`; 9 data, semuanya open | | | |

## Pengujian tanpa JavaScript (langkah 7)

| No | Langkah | Expected | Actual | Status | Bukti |
| --- | --- | --- | --- | --- | --- |
| 6 | Matikan JavaScript, reload `/courses` | Halaman tetap terbuka | | | |
| 7 | Isi q/status, klik Cari | Hasil berubah lewat reload biasa | | | |
| 8 | Pindah ke halaman 2 | Pagination tetap berfungsi, q/status terjaga | | | |

## Tambahan jika Ajax dikerjakan (DevTools > Network)

| No | Skenario | Expected | Actual | Status | Bukti |
| --- | --- | --- | --- | --- | --- |
| 9 | Ketik keyword cepat | Request dikirim sekali setelah jeda sekitar 300 ms | | | |
| 10 | Ubah filter status | Request ke `?partial=1`, hasil berubah tanpa reload | | | |
| 11 | Klik halaman 2 | Hasil berubah tanpa reload penuh | | | |
| 12 | Buka `/courses?q=web&status=open&partial=1` | Hanya blok hasil, tanpa layout | | | |

## Dashboard count (tambahan proyek)

| No | Skenario | Expected | Actual | Status |
| --- | --- | --- | --- | --- |
| 13 | Buka `/courses` | Empat angka: total kursus, kursus open, peserta, pendaftaran, cocok dengan database | | |
