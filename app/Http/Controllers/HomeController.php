<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::query()
            ->active()
            ->trending()
            ->latest()
            ->take(12)
            ->get();

        return view('home', compact('destinations'));
    }
}
