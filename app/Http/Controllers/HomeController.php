<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\View\View;
use Illuminate\Http\Request;

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

        // Get blog posts for homepage
        $blogController = new BlogController();
        $blogs = $blogController->buildBlogCollection()->take(6);

        return view('home', compact('destinations', 'blogs'));
    }




    public function honeymoon(Request $request)
    {
        $packages = collect([

            (object)[
                'title' => 'Bali Explorer Package',
                'slug' => 'bali-explorer-package',
                'image' => 'images/Himachal.jpg',
                'category' => 'Luxury',
                'days' => 6,
                'duration_text' => '6D/5N',
                'rating' => 4.8,
                'old_price' => 64999,
                'price' => 54999,
                'flight' => 'included',
                'theme' => 'Beach',
                'feature_1' => 'Hotel stay included',
                'feature_2' => 'Local transfers covered',
                'feature_3' => 'Top sightseeing spots',
            ],

            (object)[
                'title' => 'Kashmir Romance',
                'slug' => 'kashmir-romance',
                'image' => 'images/kashmir.avif',
                'category' => 'Premium',
                'days' => 8,
                'duration_text' => '8D/7N',
                'rating' => 4.9,
                'old_price' => 99999,
                'price' => 89999,
                'flight' => 'included',
                'theme' => 'Mountain',
                'feature_1' => 'Luxury resort stay',
                'feature_2' => 'Private candlelight dinner',
                'feature_3' => 'Island sightseeing',
            ],

        ]);

        /* FILTERS */

        if ($request->type) {
            $packages = $packages->where('category', $request->type);
        }

        if ($request->price) {
            $packages = $packages->where('price', '<=', (int)$request->price);
        }

        if ($request->flight) {
            $packages = $packages->where('flight', $request->flight);
        }

        if ($request->theme) {
            $packages = $packages->where('theme', $request->theme);
        }

        if ($request->duration) {

            [$min, $max] = explode('-', $request->duration);

            $packages = $packages->filter(function ($package) use ($min, $max) {
                return $package->days >= $min &&
                    $package->days <= $max;
            });
        }

        /* SORTING */

        if ($request->sort == 'low_to_high') {
            $packages = $packages->sortBy('price');
        }

        if ($request->sort == 'high_to_low') {
            $packages = $packages->sortByDesc('price');
        }

        if ($request->sort == 'rating') {
            $packages = $packages->sortByDesc('rating');
        }

        return view('honeymoon', compact('packages'));
    }
}
