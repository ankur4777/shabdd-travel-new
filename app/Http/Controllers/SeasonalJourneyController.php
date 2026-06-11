<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\SeasonalJourney;
use Illuminate\Support\Str;

class SeasonalJourneyController extends Controller
{
    public function show($slug)
    {
        $journey = SeasonalJourney::active()->where('slug', $slug)->firstOrFail();
        $relatedPackages = $this->relatedPackagesForJourney($journey);

        return view('seasonal-journeys.show', [
            'journey' => $journey,
            'relatedPackages' => $relatedPackages,
        ]);
    }

    private function relatedPackagesForJourney(SeasonalJourney $journey): array
    {
        $searchTerms = $this->journeyPackageSearchTerms($journey);

        if (empty($searchTerms)) {
            return [];
        }

        return Package::query()
            ->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query
                        ->orWhere('title', 'like', '%' . $term . '%')
                        ->orWhere('slug', 'like', '%' . $term . '%')
                        ->orWhere('city', 'like', '%' . $term . '%')
                        ->orWhere('state', 'like', '%' . $term . '%')
                        ->orWhere('country', 'like', '%' . $term . '%');
                }
            })
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (Package $package) => $this->normalizeRelatedPackage($package))
            ->all();
    }

    private function journeyPackageSearchTerms(SeasonalJourney $journey): array
    {
        $genericWords = [
            'destination',
            'holiday',
            'journey',
            'package',
            'packages',
            'seasonal',
            'tour',
            'travel',
            'trip',
            'vacation',
        ];

        return collect([
            $journey->title,
            $journey->slug,
            $journey->location,
        ])
            ->flatMap(fn ($value) => preg_split('/[^a-z0-9]+/i', Str::lower((string) $value)) ?: [])
            ->map(fn ($term) => trim((string) $term))
            ->filter(fn ($term) => $term !== '' && strlen($term) >= 3)
            ->reject(fn ($term) => in_array($term, $genericWords, true))
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeRelatedPackage(Package $package): array
    {
        $duration = trim((string) $package->duration_text);

        if ($duration === '' && $package->days) {
            $duration = (int) $package->days . 'D/' . max(0, ((int) $package->days) - 1) . 'N';
        }

        return [
            'name' => $package->title,
            'category' => $package->category,
            'travel_style' => $package->travel_style,
            'duration' => $duration !== '' ? $duration : null,
            'rating' => $package->rating,
            'price' => $package->price ? '₹' . number_format((int) $package->price) : '',
            'old_price' => $package->old_price ? '₹' . number_format((int) $package->old_price) : '',
            'image' => $this->packageMediaUrl($package->image),
            'url' => route('packages.show', $package->slug),
        ];
    }

    private function packageMediaUrl(?string $path): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return asset('images/couple-bg.jpg');
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        if (Str::startsWith($path, ['/storage/', 'storage/', '/images/', 'images/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
