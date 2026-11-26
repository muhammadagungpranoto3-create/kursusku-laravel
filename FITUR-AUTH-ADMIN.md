# Fitur Login, Dashboard & Manajemen Pengguna

## Yang ditambahkan

1. **Login role-aware**
   - Admin → redirect ke `/admin` (Admin Dashboard)
   - User → redirect ke `/dashboard` (Dashboard Personal)
   - Cek status `is_active` (akun nonaktif tidak bisa login)
   - Mencatat `last_login_at` setiap login berhasil

2. **Dashboard Personal** (`/dashboard`)
   - Selamat datang + info akun
   - Badge role & status
   - Tombol Edit Profil & Ubah Password
   - Admin bisa lompat ke Admin Panel

3. **Admin Dashboard** (`/admin`)
   - Kartu statistik: Total, Aktif, Nonaktif, Administrator
   - Tabel pengguna terbaru
   - Aktivitas login terbaru
   - Sidebar navigasi (sesuai screenshot)

4. **Manajemen Pengguna** (`/admin/users`)
   - Daftar + pencarian nama/username/email
   - Filter role & status
   - Tambah pengguna (dengan password)
   - Detail, Edit (bisa ganti password)
   - Aktifkan / Nonaktifkan
   - Hapus (kecuali diri sendiri)

5. **Profil & Password**
   - `/profil` — lihat data + form ubah password
   - `/profil/edit` — edit nama, username, email, telepon

## Cara menjalankan di Laragon

```bash
# Pastikan .env memakai MySQL
DB_CONNECTION=mysql
DB_DATABASE=kursusku
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan serve
# terminal lain: npm run dev
```

## Akun demo (setelah seed)

| Username  | Password     | Role  |
|-----------|--------------|-------|
| admin     | admin123     | admin |
| alyaaja   | password123  | user  |
| bima      | password123  | user  |
| citra     | password123  | user  |
| peserta   | peserta123   | user  |

## Route penting

- `GET /login` — form login
- `GET /dashboard` — dashboard personal (auth)
- `GET /admin` — admin dashboard (auth + admin)
- `GET /admin/users` — daftar pengguna
- `GET /admin/users/create` — tambah
- `GET /admin/users/{id}/edit` — edit (password opsional)
- `PATCH /admin/users/{id}/toggle-status` — aktif/nonaktif
- `PUT /profil/password` — ganti password sendiri
