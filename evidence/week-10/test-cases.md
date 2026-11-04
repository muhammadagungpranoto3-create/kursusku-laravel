# Uji manual pertemuan 10

| No | Skenario | Input utama | Hasil yang diharapkan | Hasil aktual | Status |
| --- | --- | --- | --- | --- | --- |
| 1 | Simpan data valid | Semua field valid, kode baru | Tersimpan, redirect, pesan sukses | | |
| 2 | Kode kosong | code kosong | Validasi gagal | | |
| 3 | Kode duplikat | WEB-101 kedua kali | Ditolak unique | | |
| 4 | Nama kosong | name kosong | Validasi gagal | | |
| 5 | Biaya negatif | fee = -1000 | Ditolak min:0 | | |
| 6 | Kuota 0 | quota = 0 | Ditolak min:1 | | |
| 7 | Status tidak valid | active | Ditolak | | |
| 8 | Daftar tampil ulang | Reload /courses | Data tetap ada | | |
