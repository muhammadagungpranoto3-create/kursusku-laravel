<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;

class HomeController extends Controller
{
    public function index()
    {
        $siteName = 'KursusKu';

        $featured = Course::query()
            ->where('status', 'open')
            ->withCount('enrollments')
            ->orderBy('code')
            ->get();

        $recent = Enrollment::with(['participant', 'course'])
            ->latest()
            ->latest('id')
            ->take(3)
            ->get();

        $stats = [
            'courses' => $featured->count(),
            'participants' => Participant::count(),
            'enrollments' => Enrollment::count(),
        ];

        return view('home', compact('siteName', 'featured', 'recent', 'stats'));
    }
}
