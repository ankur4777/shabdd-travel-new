<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = $this->adminReviews();
        $allReviews = $reviews;

        $selectedRating = (int) $request->input('rating', 0);
        $selectedSource = trim((string) $request->input('source', ''));
        $selectedSort = (string) $request->input('sort', 'newest');

        if (in_array($selectedRating, [1, 2, 3, 4, 5], true)) {
            $reviews = $reviews->where('rating', $selectedRating);
        }

        if ($selectedSource !== '') {
            $reviews = $reviews->where('source_key', $selectedSource);
        }

        $reviews = match ($selectedSort) {
            'highest' => $reviews->sort(function (array $left, array $right): int {
                return [$right['rating'], $right['updated_at']?->getTimestamp() ?? 0]
                    <=> [$left['rating'], $left['updated_at']?->getTimestamp() ?? 0];
            }),
            'lowest' => $reviews->sort(function (array $left, array $right): int {
                return [$left['rating'], -($left['updated_at']?->getTimestamp() ?? 0)]
                    <=> [$right['rating'], -($right['updated_at']?->getTimestamp() ?? 0)];
            }),
            default => $reviews->sortByDesc('updated_at'),
        };

        $perPage = 8;
        $page = max(1, (int) $request->input('page', 1));
        $paginatedReviews = new LengthAwarePaginator(
            $reviews->forPage($page, $perPage)->values(),
            $reviews->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $ratingCounts = collect(range(1, 5))
            ->mapWithKeys(fn (int $rating) => [$rating => $allReviews->where('rating', $rating)->count()]);

        $averageRating = $allReviews->isEmpty()
            ? 0
            : round((float) $allReviews->avg('rating'), 1);

        $sources = $allReviews
            ->unique('source_key')
            ->sortBy('source_label')
            ->map(fn (array $review) => [
                'value' => $review['source_key'],
                'label' => $review['source_label'],
            ])
            ->values();

        return view('reviews.index', compact(
            'paginatedReviews',
            'ratingCounts',
            'averageRating',
            'sources',
            'selectedRating',
            'selectedSource',
            'selectedSort'
        ))->with('reviewCount', $allReviews->count());
    }

    private function adminReviews(): Collection
    {
        $destinationReviews = Destination::query()
            ->whereNotNull('testimonials')
            ->get(['id', 'name', 'slug', 'testimonials', 'updated_at'])
            ->flatMap(function (Destination $destination): Collection {
                return collect($destination->testimonials)
                    ->filter(fn ($review) => is_array($review) && filled($review['review'] ?? null))
                    ->map(fn (array $review, $index) => $this->normalizeReview(
                        $review,
                        'destination-' . $destination->id . '-' . $index,
                        'destination:' . $destination->id,
                        $destination->name,
                        $destination->updated_at
                    ));
            });

        return $destinationReviews
            ->filter()
            ->values();
    }

    private function normalizeReview(
        array $review,
        string $id,
        string $sourceKey,
        string $sourceLabel,
        mixed $updatedAt
    ): array {
        $name = trim((string) ($review['name'] ?? 'SHABDD Traveller'));
        $rating = max(1, min(5, (int) round((float) ($review['rating'] ?? 5))));

        return [
            'id' => $id,
            'name' => $name !== '' ? $name : 'SHABDD Traveller',
            'location' => trim((string) ($review['location'] ?? '')),
            'rating' => $rating,
            'review' => trim(strip_tags((string) $review['review'])),
            'images' => collect($review['images'] ?? [])
                ->filter(fn ($image) => is_string($image) && trim($image) !== '')
                ->take(5)
                ->map(fn (string $image) => $this->reviewImageUrl($image))
                ->values()
                ->all(),
            'source_key' => $sourceKey,
            'source_label' => $sourceLabel,
            'updated_at' => $updatedAt,
        ];
    }

    private function reviewImageUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (Str::startsWith($path, ['storage/', 'images/'])) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
