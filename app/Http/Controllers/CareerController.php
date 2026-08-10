<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(): View
    {
        $careers = Career::query()
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('careers.index', compact('careers'));
    }

    public function show(Career $career): View
    {
        abort_unless($career->is_active, 404);

        return view('careers.show', compact('career'));
    }

}
