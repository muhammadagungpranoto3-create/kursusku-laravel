<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['WEB-101', 'Web Dasar', 'HTML, CSS, dan dasar web.', 300000, 25, 'open'],
            ['PHP-101', 'PHP Fundamental', 'Variabel, function, dan logika PHP.', 400000, 25, 'open'],
            ['LRV-101', 'Laravel Dasar', 'Route, controller, Blade, dan Eloquent.', 500000, 20, 'open'],
            ['SQL-101', 'MySQL Dasar', 'SELECT, INSERT, tipe data, dan primary key.', 350000, 30, 'open'],
            ['UI-101', 'Bootstrap UI', 'Layout Bootstrap untuk antarmuka web.', 300000, 25, 'draft'],
            ['JS-101', 'JavaScript Dasar', 'Event, DOM, dan interaksi halaman.', 400000, 20, 'open'],
            ['AJAX-101', 'jQuery dan Ajax', 'Request Ajax tanpa memuat ulang halaman.', 450000, 20, 'draft'],
            ['API-101', 'REST API Dasar', 'Endpoint JSON dan konsep REST.', 550000, 18, 'closed'],
        ];

        foreach ($courses as $i => $item) {
            Course::updateOrCreate(
                ['code' => $item[0]],
                [
                    'name' => $item[1],
                    'description' => $item[2],
                    'fee' => $item[3],
                    'quota' => $item[4],
                    'start_date' => now()->addDays(7 + ($i * 7))->toDateString(),
                    'status' => $item[5],
                ],
            );
        }
    }
}
