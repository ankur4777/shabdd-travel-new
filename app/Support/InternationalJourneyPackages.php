<?php

namespace App\Support;

use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class InternationalJourneyPackages
{
    public static function forJourney(array $journey, int $limit = 3): Collection
    {
        $terms = static::terms($journey);

        if ($terms->isEmpty()) {
            return collect();
        }

        return Package::query()
            ->international()
            ->where(function (Builder $query) use ($terms): void {
                foreach ($terms as $term) {
                    $query->orWhere('title', 'like', '%' . $term . '%');
                }
            })
            ->orderByDesc('featured')
            ->orderByDesc('rating')
            ->orderBy('price')
            ->take($limit)
            ->get();
    }

    private static function terms(array $journey): Collection
    {
        return collect($journey['package_terms'] ?? $journey['packageTerms'] ?? [])
            ->merge([
                $journey['short_name'] ?? null,
                $journey['shortName'] ?? null,
                $journey['country'] ?? null,
            ])
            ->merge($journey['route'] ?? [])
            ->flatMap(fn ($term) => static::splitTerm($term))
            ->filter()
            ->unique(fn (string $term) => Str::lower($term))
            ->values();
    }

    private static function splitTerm(?string $term): array
    {
        $term = trim((string) $term);

        if ($term === '') {
            return [];
        }

        return collect(preg_split('/[·,&\/]+/', $term) ?: [])
            ->map(fn (string $part) => trim($part))
            ->filter(fn (string $part) => Str::length($part) >= 3)
            ->values()
            ->all();
    }
}
