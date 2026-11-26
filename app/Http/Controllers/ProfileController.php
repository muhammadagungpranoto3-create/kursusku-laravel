<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;

class ProfileController extends Controller
{
    /** Halaman "Profil Saya" / dashboard setelah login. */
    public function show()
    {
        $stats = [
            'courses' => Course::count(),
            'participants' => Participant::count(),
            'enrollments' => Enrollment::count(),
        ];

        return view('profile.show', [
            'user' => auth()->user(),
            'stats' => $stats,
        ]);
    }
}
