<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * UAS Project Akhir - tabel users untuk login.
 * Tabel users bawaan Laravel (name, email, password, remember_token) sudah ada,
 * jadi migration ini hanya menambah kolom username dan role.
 * Kolom password menyimpan HASH bcrypt, bukan teks asli.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 30)->nullable()->unique()->after('name');
            $table->string('role', 20)->default('user')->after('password'); // admin | user
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'role']);
        });
    }
};
