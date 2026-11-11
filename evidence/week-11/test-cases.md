# Test matrix pertemuan 11 - CRUD Course lengkap

Isi kolom **Actual**, **Status**, dan **Bukti** setelah Anda menjalankan setiap kasus di browser.
Jangan isi sebelum benar-benar diuji.

| No | Skenario | Input / tindakan | Expected | Actual | Status | Bukti |
| --- | --- | --- | --- | --- | --- | --- |
| 1 | Duplicate code saat create | Pakai code Course yang sudah ada | Ditolak; error dekat field code | | | |
| 2 | Nama kosong | name = "" | Ditolak; name required | | | |
| 3 | Nama terlalu pendek | name = "AI" | Ditolak; minimal 3 karakter | | | |
| 4 | Fee negatif | fee = -1000 | Ditolak; minimal 0 | | | |
| 5 | Fee bukan integer | fee = abc (lewat DevTools) | Ditolak; harus integer | | | |
| 6 | Quota nol | quota = 0 | Ditolak | | | |
| 7 | Quota 501 | quota = 501 | Ditolak | | | |
| 8 | Boundary quota minimum | quota = 1 | Diterima | | | |
| 9 | Boundary quota maksimum | quota = 500 | Diterima | | | |
| 10 | Tanggal invalid | Ubah nilai start_date lewat DevTools | Ditolak oleh rule date | | | |
| 11 | Status invalid | status = active (lewat DevTools) | Ditolak; hanya draft/open/closed | | | |
| 12 | Update dengan code sendiri | Edit Course, ubah nama saja | Berhasil | | | |
| 13 | Update ke code Course lain | Ganti code ke code Course lain | Ditolak unique | | | |
| 14 | Update normal | Ubah nama, fee, quota, atau status | Berhasil; detail menampilkan data baru | | | |
| 15 | Delete | Hapus Course dummy DEL-001 (Cancel dulu, lalu OK) | Data hilang dari index + flash sukses | | | |

Kasus yang sangat disarankan: 1, 4, 6, 7, 10, 11, 12, 13, 15. Minimal 12 kasus.
