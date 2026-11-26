<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Akun awal untuk demo login. Jalankan:  php artisan db:seed --class=UserSeeder
 * Password di bawah akan tersimpan sebagai HASH bcrypt di kolom users.password.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@kursusku.test',
                'password' => 'admin123',
                'role' => 'admin',
            ],
        );

        User::updateOrCreate(
            ['username' => 'peserta'],
            [
                'name' => 'Peserta Demo',
                'email' => 'peserta@kursusku.test',
                'password' => 'peserta123',
                'role' => 'user',
            ],
        );
    }
}
