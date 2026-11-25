<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseDiscoverySeeder extends Seeder
{
    /**
     * 24 kursus dummy untuk menguji search, filter, dan pagination.
     * Dipakai bersama CourseSeeder (8 data) sehingga total 32:
     * open 19, closed 7, draft 6. Aman diulang (dicari lewat code).
     */
    public function run(): void
    {
        $courses = [
            ['DMY-01', 'Web Modern Dasar', 'open'],
            ['DMY-02', 'Web Modern Lanjut', 'open'],
            ['DMY-03', 'Desain Web Responsif', 'open'],
            ['DMY-04', 'Laravel Routing Lanjut', 'open'],
            ['DMY-05', 'Laravel Eloquent Relasi', 'open'],
            ['DMY-06', 'PHP OOP', 'open'],
            ['DMY-07', 'Validasi Form PHP', 'open'],
            ['DMY-08', 'MySQL Join dan Subquery', 'open'],
            ['DMY-09', 'Git dan GitHub Dasar', 'open'],
            ['DMY-10', 'Bootstrap Komponen', 'open'],
            ['DMY-11', 'jQuery Event Handling', 'open'],
            ['DMY-12', 'Testing Aplikasi Laravel', 'open'],
            ['DMY-13', 'Deploy Laravel ke Hosting', 'open'],
            ['DMY-14', 'Keamanan Aplikasi Web', 'open'],
            ['DMY-15', 'Algoritma Dasar', 'closed'],
            ['DMY-16', 'Struktur Data PHP', 'closed'],
            ['DMY-17', 'Web Statis HTML', 'closed'],
            ['DMY-18', 'CSS Flexbox dan Grid', 'closed'],
            ['DMY-19', 'Pengantar Basis Data', 'closed'],
            ['DMY-20', 'Pengantar Pemrograman', 'closed'],
            ['DMY-21', 'Laravel Queue', 'draft'],
            ['DMY-22', 'Laravel API Resource', 'draft'],
            ['DMY-23', 'Autentikasi Laravel', 'draft'],
            ['UNQ-777', 'Kriptografi Terapan', 'draft'], // satu-satunya hasil untuk uji "1 hasil"
        ];

        foreach ($courses as $i => [$code, $name, $status]) {
            Course::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'description' => 'Data dummy pengujian pencarian dan pagination.',
                    'fee' => 250000 + (($i % 5) * 50000),
                    'quota' => 20 + ($i % 4) * 5,
                    'start_date' => now()->addDays(14 + $i * 3)->toDateString(),
                    'status' => $status,
                ],
            );
        }
    }
}
