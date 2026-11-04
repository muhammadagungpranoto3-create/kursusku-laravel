# Langkah pertemuan 10 — file siap tempel

Lanjutkan project `kursusku` yang sudah ada. Jangan `laravel new` lagi.

Zip ini hanya berisi file yang berubah. Salin dengan mempertahankan jalur folder, lalu hapus file model huruf kecil jika masih ada.

## Yang rusak di zip sebelumnya

- `app/Models/course.php` class-nya `course` dan `$fillable` kosong, jadi `Course::create()` gagal.
- Migration belum sesuai blueprint (panjang kolom, enum status, `start_date` masih boleh kosong).
- `routes/web.php` hanya punya `GET /courses`. Route `courses.create` dan `courses.store` belum ada, padahal view memanggilnya.
- `resources/views/layouts/app.blade.php` ada potongan Blade nyasar setelah `</html>`.
- `resources/views/enrollments/create.blade.php` berisi dua dokumen HTML yang tertumpuk.
- Availability masih array dummy pertemuan 9.

## Urutan di Laragon

1. Start All. Database MySQL `kursusku` harus sudah ada (utf8mb4).
2. `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kursusku
DB_USERNAME=root
DB_PASSWORD=
```

3. Hapus `app/Models/course.php` bila masih ada. Pakai `app/Models/Course.php`.
4. Timpa file dari zip ini ke folder project yang sama.
5. Jika migration `create_courses_table` **belum** pernah jalan:

```
php artisan config:clear
php artisan migrate
```

6. Jika migration itu **sudah** jalan dengan skema lama dan tabel `courses` masih kosong:

```
php artisan migrate:rollback --step=1
php artisan migrate
```

Jangan `migrate:fresh` kalau database sudah berisi data lain.

7. Isi 8 data latihan:

```
php artisan db:seed --class=CourseSeeder
```

`updateOrCreate` dipakai supaya kode yang sama tidak error dua kali. Tetap coba simpan minimal satu kursus baru lewat form `/courses/create`.

8. Cek route:

```
php artisan route:list --name=courses
```

Harus ada `courses.index`, `courses.create`, `courses.store`, dan `courses.availability`.

9. Buka `/courses`, lalu `/courses/create`.

## Alur yang harus bisa dijelaskan

Browser form → `POST /courses` (`courses.store`) → `CourseController@store` validasi → `Course::create()` INSERT → redirect `courses.index` → `Course::latest()->get()` SELECT → Blade.

Jika validasi gagal, INSERT tidak dijalankan. Input lama kembali lewat `old()`, pesan lewat `@error`.

## Delapan uji

| No | Skenario | Harapan |
| --- | --- | --- |
| 1 | Semua field valid, kode baru | Tersimpan, redirect, pesan sukses |
| 2 | Kode kosong | Ditolak |
| 3 | Kode WEB-101 lagi | Ditolak, unique |
| 4 | Nama kosong | Ditolak |
| 5 | Biaya -1000 | Ditolak, min 0 |
| 6 | Kuota 0 | Ditolak, min 1 |
| 7 | Status selain draft/open/closed | Ditolak |
| 8 | Muat ulang `/courses` | Data tetap ada |

## Availability

`GET /courses/{id}/availability` sekarang mengembalikan `id`, `code`, `name`, `quota`, `status` dari tabel. Belum menghitung sisa kursi, karena peserta belum ada.
