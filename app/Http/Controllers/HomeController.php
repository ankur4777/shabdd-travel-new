<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Package;

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

        $trendingPackages = Package::where('category', 'Trending')
            ->latest()
            ->take(8)
            ->get();

        $blogController = new BlogController();
        $blogs = $blogController->buildBlogCollection()->take(6);

        return view('home', compact(
            'destinations',
            'blogs',
            'trendingPackages'
        ));
    }




    public function honeymoon(Request $request)
    {
        $packages = Package::query()
            ->where('travel_style', 'honeymoon');

        /* FILTERS */

        if ($request->type) {
            $packages->where('category', $request->type);
        }

        if ($request->price) {
            $packages->where('price', '<=', (int)$request->price);
        }

        if ($request->flight) {
            $packages->where('flight', $request->flight);
        }

        if ($request->theme) {
            $packages->where('theme', $request->theme);
        }

        if ($request->duration) {

            [$min, $max] = explode('-', $request->duration);

            $packages->whereBetween('days', [$min, $max]);
        }

        /* SORTING */

        if ($request->sort == 'low_to_high') {
            $packages->orderBy('price');
        }

        if ($request->sort == 'high_to_low') {
            $packages->orderByDesc('price');
        }

        if ($request->sort == 'rating') {
            $packages->orderByDesc('rating');
        }

        $packages = $packages->latest()->get();

        return view('honeymoon', compact('packages'));
    }
   public function packageDetails($slug)
{
    $package = Package::where('slug', $slug)->firstOrFail();

    return view('package-details', compact('package'));
}
}
