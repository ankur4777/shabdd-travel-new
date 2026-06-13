<?php

namespace App\Http\Controllers;

use App\Models\Package; // Make sure your model is named Package
use Illuminate\Http\Request;

class DomesticTourController extends Controller
{
    public function under25k()
    {
        // Fetch packages under 25k
        $packages = Package::where('type', 'domestic')
            ->where('price', '<=', 25000)
            ->get();

        return view('domestic-tours.under-25k', compact('packages'));
    }

    public function familySpecials()
    {
        // Fetch family category packages
        $packages = Package::where('type', 'domestic')
            ->where('category', 'family')
            ->get();

        return view('domestic-tours.family-specials', compact('packages'));
    }

    public function honeymoonPicks()
    {
        // Fetch honeymoon category packages
        $packages = Package::where('type', 'domestic')
            ->where('category', 'honeymoon')
            ->get();

        return view('domestic-tours.honeymoon-picks', compact('packages'));
    }

    public function allDomestic()
    {
        $packages = Package::where('type', 'domestic')->get();

        return view('domestic-tours.all-domestic', compact('packages'));
    }
}
