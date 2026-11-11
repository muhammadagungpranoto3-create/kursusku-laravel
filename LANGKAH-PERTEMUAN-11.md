# Langkah pertemuan 11 - CRUD Course lengkap

Lanjutkan project `kursusku` yang sama. Jangan `laravel new` lagi.
Zip ini hanya berisi file yang berubah. Salin dengan mempertahankan jalur folder, timpa file lama.

## Daftar file

| File | Status | Langkah panduan |
| --- | --- | --- |
| `app/Http/Controllers/CourseController.php` | timpa | 1, 7, 9 (show, store, edit, update, destroy) |
| `app/Http/Requests/StoreCourseRequest.php` | baru | 4-5 |
| `app/Http/Requests/UpdateCourseRequest.php` | baru | 4, 6 |
| `resources/views/courses/show.blade.php` | baru | 2 |
| `resources/views/courses/edit.blade.php` | baru | 8 |
| `resources/views/courses/index.blade.php` | timpa | 3 (tombol Detail, Edit, Hapus) |
| `resources/views/courses/create.blade.php` | timpa | 10 (error per field) |
| `tests/Feature/CourseCrudTest.php` | baru | opsional, uji otomatis |
| `evidence/week-11/*` | baru | test matrix + log AI |

## Urutan di Laragon

1. **Langkah 0.** Start All, buka folder proyek, lalu `php artisan route:list --name=courses`.
   Harus muncul index, create, store, show, edit, update, destroy.
2. Salin semua file dari zip ke proyek.
3. Jalankan `composer run dev` (atau `php artisan serve` + `npm run dev`).
4. Tidak ada migration baru. Jika data kosong: `php artisan db:seed --class=CourseSeeder`.
5. **Checkpoint 1.** Buka `/courses/1`, cocokkan semua field dengan MySQL. Buka `/courses/999999`, harus 404.
6. **Checkpoint 2.** Buka `/courses/1/edit`, ubah nama saja, simpan. Harus kembali ke halaman detail dengan pesan sukses.
7. Uji validasi satu per satu memakai `evidence/week-11/test-cases.md`.
8. Uji delete paling akhir, pakai Course dummy `DEL-001`.
9. Opsional: `php artisan test --filter=CourseCrudTest`.

## Penyesuaian terhadap panduan

- `show.blade.php` tidak menulis flash message sendiri karena `layouts/app.blade.php` sudah menampilkannya (kalau ditulis lagi, pesan muncul dua kali).
- Format tanggal di edit memakai `Y-m-d` (di PDF tertulis `Y-md`, itu salah ketik).
- Form create dan edit diberi `novalidate`. Tanpa itu, browser menahan nilai seperti quota 0 atau 501 sebelum sampai ke server, sehingga validasi Form Request tidak bisa dibuktikan.
- Tampilan memakai kelas proyek (`form-glass`, `btn-accent`, `seat-pill`) supaya konsisten dengan pertemuan sebelumnya.

## Untuk kasus uji lewat DevTools (5, 10, 11)

Klik kanan field, Inspect, ubah atribut `value` (atau `<option value>`) menjadi nilai uji, lalu Simpan.

## Bukti yang dikumpulkan

Screenshot route list, show, edit, error duplicate code, error quota 501, update sukses, delete sukses,
`test-cases.md` yang sudah terisi, dan `ai-usage-log.md`. Simpan di `evidence/week-11/`
(panduan menyebut `meeting-10`, tetapi folder proyek Anda memakai pola `week-NN`).
