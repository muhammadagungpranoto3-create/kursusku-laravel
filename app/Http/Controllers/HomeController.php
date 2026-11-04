<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $siteName = 'KursusKu';

        $featured = Course::query()
            ->where('status', 'open')
            ->orderBy('code')
            ->get();

        return view('home', compact('siteName', 'featured'));
    }
}
