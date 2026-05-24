<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\PilgrimageDestination;
use App\Models\PilgrimageTour;
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

        // Get pilgrimage destinations
        $pilgrimageDestinations = PilgrimageDestination::query()
            ->active()
            ->ordered()
            ->get();

        // Get pilgrimage tours
        $pilgrimageTours = PilgrimageTour::query()
            ->active()
            ->ordered()
            ->get();

        // Get blog posts for homepage
        $blogController = new BlogController();
        $blogs = $blogController->buildBlogCollection()->take(6);

        return view('home', compact('destinations', 'blogs', 'pilgrimageDestinations', 'pilgrimageTours'));
    }
}
