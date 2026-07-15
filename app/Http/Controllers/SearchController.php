<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Destination;
use App\Models\Package;
use App\Support\MediaUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function live(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('q', ''));

        if (Str::length($query) < 2) {
            return response()->json([
                'query' => $query,
                'results' => [],
            ]);
        }

        $term = '%' . addcslashes($query, '%_\\') . '%';

        $destinations = Destination::query()
            ->active()
            ->where(function ($builder) use ($term) {
                $builder
                    ->where('name', 'like', $term)
                    ->orWhere('country', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('short_description', 'like', $term)
                    ->orWhere('about', 'like', $term)
                    ->orWhere('overview', 'like', $term);
            })
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn(Destination $destination) => [
                'title' => $destination->name,
                'type' => 'Destination',
                'subtitle' => collect([$destination->location, $destination->country, $destination->category])
                    ->filter()
                    ->unique()
                    ->implode(' • '),
                'description' => $this->excerpt($destination->short_description ?: $destination->about ?: $destination->overview),
                'image' => $this->mediaUrl($destination->image_url ?: $destination->hero_image),
                'url' => route('destinations.show', $destination, false),
            ]);

        $packages = Package::query()
            ->where(function ($builder) use ($term) {
                $builder
                    ->where('title', 'like', $term)
                    ->orWhere('slug', 'like', $term)
                    ->orWhere('country', 'like', $term)
                    ->orWhere('state', 'like', $term)
                    ->orWhere('city', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('travel_style', 'like', $term)
                    ->orWhere('theme', 'like', $term)
                    ->orWhere('description', 'like', $term);
            })
            ->latest()
            ->limit(6)
            ->get()
            ->map(fn(Package $package) => [
                'title' => $package->title,
                'type' => 'Package',
                'subtitle' => collect([$package->city, $package->state, $package->country, $package->duration_text])
                    ->filter()
                    ->unique()
                    ->implode(' • '),
                'description' => $this->excerpt($package->description),
                'image' => $this->mediaUrl($package->image),
                'url' => route('packages.show', $package->slug, false),
                'price' => $package->price ? '₹' . number_format((int) $package->price) : null,
            ]);

        $blogs = Blog::query()
            ->active()
            ->with('destination')
            ->whereHas('destination', fn($builder) => $builder->active())
            ->where(function ($builder) use ($term) {
                $builder
                    ->where('title', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('excerpt', 'like', $term)
                    ->orWhere('content', 'like', $term)
                    ->orWhereHas('destination', fn($destinationQuery) => $destinationQuery->where('name', 'like', $term));
            })
            ->latest('published_at')
            ->limit(4)
            ->get()
            ->map(fn(Blog $blog) => [
                'title' => $blog->title,
                'type' => 'Blog',
                'subtitle' => collect([$blog->destination?->name, $blog->category])
                    ->filter()
                    ->unique()
                    ->implode(' • '),
                'description' => $this->excerpt($blog->excerpt),
                'image' => $this->mediaUrl($blog->image ?: $blog->destination?->image_url),
                'url' => route('blog.show', [
                    'destination' => $blog->destination->slug,
                    'blog' => $blog->slug,
                ], false),
            ]);

        return response()->json([
            'query' => $query,
            'results' => $destinations
                ->concat($packages)
                ->concat($blogs)
                ->take(12)
                ->values(),
        ]);
    }

    private function mediaUrl(?string $path): string
    {
        return MediaUrl::relative($path);
    }

    private function excerpt(?string $value): string
    {
        return Str::limit(html_entity_decode(strip_tags((string) $value), ENT_QUOTES, 'UTF-8'), 110);
    }
}
