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
                'name' => 'Administrator KursusKu',
                'email' => 'admin@kursusku.test',
                'password' => 'admin123',
                'role' => 'admin',
                'is_active' => true,
                'phone' => '081200000001',
                'last_login_at' => now(),
            ],
        );

        User::updateOrCreate(
            ['username' => 'bima'],
            [
                'name' => 'Bima Putra',
                'email' => 'bima@kursusku.test',
                'password' => 'password123',
                'role' => 'user',
                'is_active' => true,
                'phone' => '081200000003',
            ],
        );

        User::updateOrCreate(
            ['username' => 'citra'],
            [
                'name' => 'Citra Nabila',
                'email' => 'citra@kursusku.test',
                'password' => 'password123',
                'role' => 'user',
                'is_active' => true,
                'phone' => '081200000004',
            ],
        );

        User::updateOrCreate(
            ['username' => 'alyaaja'],
            [
                'name' => 'Alya Rahmatina',
                'email' => 'alya@kursusku.test',
                'password' => 'password123',
                'role' => 'user',
                'is_active' => true,
                'phone' => '081200000002',
                'last_login_at' => now()->subMinute(),
            ],
        );

        User::updateOrCreate(
            ['username' => 'peserta'],
            [
                'name' => 'Peserta Demo',
                'email' => 'peserta@kursusku.test',
                'password' => 'peserta123',
                'role' => 'user',
                'is_active' => true,
            ],
        );
    }
}
