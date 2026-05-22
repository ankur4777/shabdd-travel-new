<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = $this->buildBlogCollection();

        return view('blog.index', [
            'blogs' => $blogs,
            'featured' => $blogs->first(),
            'highlights' => $blogs->take(4)->values(),
            'destinations' => $blogs
                ->pluck('destination_name')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    public function show(Destination $destination, string $blog): View
    {
        abort_unless($destination->is_active, 404);

        $blogs = $this->buildBlogCollection();

        $post = $blogs->first(function (array $item) use ($destination, $blog) {
            return $item['destination_slug'] === $destination->slug && $item['slug'] === $blog;
        });

        abort_if($post === null, 404);

        $relatedPosts = $blogs
            ->reject(fn (array $item) => $item['url'] === $post['url'])
            ->filter(fn (array $item) => $item['destination_slug'] === $destination->slug || $item['category'] === $post['category'])
            ->take(3)
            ->values();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = $blogs
                ->reject(fn (array $item) => $item['url'] === $post['url'])
                ->take(3)
                ->values();
        }

        $destinationBlogs = $blogs
            ->filter(fn (array $item) => $item['destination_slug'] === $destination->slug)
            ->take(4)
            ->values();

        return view('blog.show', [
            'destination' => $destination,
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'destinationBlogs' => $destinationBlogs,
        ]);
    }

    private function buildBlogCollection(): Collection
    {
        return Destination::query()
            ->active()
            ->latest()
            ->get()
            ->flatMap(function (Destination $destination) {
                return collect($destination->blogs ?? [])
                    ->values()
                    ->map(function ($blog, int $index) use ($destination) {
                        return $this->normalizeBlog($destination, $blog, $index);
                    });
            })
            ->sortByDesc('published_timestamp')
            ->values();
    }

    private function normalizeBlog(Destination $destination, mixed $blog, int $index): array
    {
        $blogData = is_array($blog) ? $blog : ['title' => (string) $blog];
        $title = trim((string) ($blogData['title'] ?? 'Travel Story'));
        $excerpt = trim((string) ($blogData['excerpt'] ?? ''));
        $publishedAt = (string) ($blogData['date'] ?? now()->subDays($index + 1)->toDateString());
        $slug = Str::slug($blogData['slug'] ?? $title) ?: 'travel-story-' . ($index + 1);
        $readingTime = (int) ($blogData['reading_time'] ?? max(3, min(9, 4 + (int) (strlen($excerpt) / 120))));
        $category = $blogData['category'] ?? $this->inferCategory($destination->name, $title);

        return [
            'slug' => $slug,
            'destination_slug' => $destination->slug,
            'destination_name' => $destination->name,
            'country' => $destination->country,
            'title' => $title,
            'excerpt' => $excerpt !== '' ? $excerpt : $this->buildExcerpt($destination->name, $title),
            'image' => $blogData['image'] ?? $destination->image_url,
            'published_at' => $publishedAt,
            'published_timestamp' => strtotime($publishedAt) ?: now()->timestamp,
            'category' => $category,
            'reading_time' => $readingTime,
            'author' => $blogData['author'] ?? 'Shabdd Travel Team',
            'role' => $blogData['role'] ?? 'Verified travel writer',
            'content_paragraphs' => $this->buildContentParagraphs($destination, $title, $excerpt),
            'highlights' => $this->buildHighlights($destination),
            'url' => route('blog.show', [
                'destination' => $destination->slug,
                'blog' => $slug,
            ]),
        ];
    }

    private function buildExcerpt(string $destinationName, string $title): string
    {
        return $title . ' is a practical guide to plan your ' . $destinationName . ' trip with better timing, smoother logistics, and the right travel style.';
    }

    private function buildContentParagraphs(Destination $destination, string $title, string $excerpt): array
    {
        $intro = trim($excerpt) !== ''
            ? $excerpt
            : $this->buildExcerpt($destination->name, $title);

        return [
            $intro,
            'For travelers heading to ' . $destination->name . ', the biggest win is planning around the season, trip length, and hotel zone before locking the final itinerary.',
            'If you want a shorter break, keep the route focused and build your days around the strongest experiences: beaches, viewpoints, local food, and one signature activity.',
            'For a longer holiday, use slower mornings and one or two flexible slots so the trip still feels relaxed instead of overpacked.',
            'This guide is designed to help you turn a simple destination idea into a trip that feels personal, polished, and easy to manage from start to finish.',
        ];
    }

    private function buildHighlights(Destination $destination): array
    {
        $highlights = collect($destination->highlights ?? [])
            ->filter()
            ->values()
            ->take(3)
            ->all();

        if (!empty($highlights)) {
            return $highlights;
        }

        return [
            $destination->name . ' travel timing',
            'Best stay area planning',
            'Must-do experiences from the guide',
        ];
    }

    private function inferCategory(string $destinationName, string $title): string
    {
        $haystack = Str::lower($destinationName . ' ' . $title);

        return match (true) {
            Str::contains($haystack, ['honeymoon', 'romance', 'couple']) => 'Honeymoon',
            Str::contains($haystack, ['budget', 'cost', 'under']) => 'Budget Travel',
            Str::contains($haystack, ['adventure', 'trek', 'safari']) => 'Adventure',
            Str::contains($haystack, ['family']) => 'Family Trips',
            default => 'Destination Guide',
        };
    }
}
