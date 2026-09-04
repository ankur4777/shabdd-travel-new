<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Support\MediaUrl;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $allBlogs = $this->buildBlogCollection();
        $blogs = $allBlogs;

        if ($category = trim((string) request('category'))) {
            $blogs = $blogs->filter(function (array $blog) use ($category) {
                return strcasecmp(trim((string) $blog['category']), $category) === 0;
            })->values();
        }

        if ($destination = trim((string) request('destination'))) {
            $blogs = $blogs->filter(function (array $blog) use ($destination) {
                return strcasecmp(trim((string) $blog['destination_name']), $destination) === 0;
            })->values();
        }

        if ($search = trim((string) request('search'))) {
            $term = mb_strtolower($search);

            $blogs = $blogs->filter(function (array $blog) use ($term) {
                $haystack = mb_strtolower(implode(' ', [
                    $blog['title'] ?? '',
                    $blog['excerpt'] ?? '',
                    $blog['category'] ?? '',
                    $blog['destination_name'] ?? '',
                ]));

                return str_contains($haystack, $term);
            })->values();
        }

        return view('blog.index', [
            'allBlogs' => $allBlogs,
            'blogs' => $blogs,
            'featured' => $blogs->first(),
            'highlights' => $blogs->take(4)->values(),
            'latestStories' => $blogs->values(),
            'blogDestinations' => $allBlogs
                ->pluck('destination_name')
                ->map(fn ($destination) => trim((string) $destination))
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
            ->reject(fn(array $item) => $item['url'] === $post['url'])
            ->filter(fn(array $item) => $item['destination_slug'] === $destination->slug || $item['category'] === $post['category'])
            ->take(3)
            ->values();

        if ($relatedPosts->isEmpty()) {
            $relatedPosts = $blogs
                ->reject(fn(array $item) => $item['url'] === $post['url'])
                ->take(3)
                ->values();
        }

        $destinationBlogs = $blogs
            ->filter(fn(array $item) => $item['destination_slug'] === $destination->slug)
            ->take(4)
            ->values();

        return view('blog.show', [
            'destination' => $destination,
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'destinationBlogs' => $destinationBlogs,
            'blogs' => $blogs,
            'highlights' => $blogs->take(5)->values(),
            'latestStories' => $blogs->values(),
            'blogDestinations' => $blogs
                ->pluck('destination_name')
                ->filter()
                ->unique()
                ->sort()
                ->values(),
        ]);
    }

    public function buildBlogCollection(): Collection
    {
        return Destination::query()
            ->active()
            ->with(['blogPosts' => function ($query) {
                $query->where('is_active', true)->orderBy('published_at', 'desc');
            }])
            ->latest()
            ->get()
            ->flatMap(function (Destination $destination) {
                return $destination->blogPosts
                    ->values()
                    ->map(function ($blog, int $index) use ($destination) {
                        return $this->normalizeBlog($destination, $blog, $index);
                    });
            })
            ->sortByDesc('published_timestamp')
            ->values();
    }

    private function normalizeBlog(Destination $destination, $blog, int $index): array
    {
        // Handle Blog model instances
        $blogData = $blog instanceof \App\Models\Blog ? $blog->toArray() : (is_array($blog) ? $blog : ['title' => (string) $blog]);

        $title = trim((string) ($blogData['title'] ?? 'Travel Story'));
        $excerpt = trim((string) ($blogData['excerpt'] ?? ''));
        $publishedAt = (string) ($blogData['published_at'] ?? now()->subDays($index + 1)->toDateString());
        $slug = $blogData['slug'] ?? Str::slug($title) ?: 'travel-story-' . ($index + 1);
        $readingTime = (int) ($blogData['reading_time'] ?? max(3, min(9, 4 + (int) (strlen($excerpt) / 120))));
        $category = $blogData['category'] ?? $this->inferCategory($destination->name, $title);
        $image = $this->mediaUrl($blogData['image'] ?? $destination->image_url);
        $destinationName = trim((string) $destination->name);

        return [
            'slug' => $slug,
            'destination_slug' => $destination->slug,
            'destination_name' => $destinationName,
            'country' => $destination->country,
            'title' => $title,
            'excerpt' => $excerpt !== '' ? $excerpt : $this->buildExcerpt($destinationName, $title),
            'image' => $image,
            'image_alt_text' => trim((string) ($blogData['image_alt_text'] ?? '')) ?: $title . ' travel guide image',
            'published_at' => $publishedAt,
            'published_at_display' => \Carbon\Carbon::parse($publishedAt)->format('M d, Y'),
            'published_timestamp' => strtotime($publishedAt) ?: now()->timestamp,
            'category' => $category,
            'reading_time' => $readingTime,
            'author' => $blogData['author'] ?? 'Shabdd Travel Team',
            'role' => $blogData['role'] ?? 'Verified travel writer',
            'content_paragraphs' => $this->buildContentParagraphs($destination, $title, $excerpt),
            'highlights' => $blogData['highlights'] ?? $this->buildHighlights($destination),
            'quick_facts' => $blogData['quick_facts'] ?? $this->buildQuickFacts($destination),
            'itinerary' => $blogData['itinerary'] ?? $this->buildSuggestedItinerary($destination),
            'faqs' => $blogData['faqs'] ?? $this->buildFaqs($destination, $title),
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

    private function mediaUrl(?string $path): string
    {
        return MediaUrl::asset($path);
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

    private function buildQuickFacts(Destination $destination): array
    {
        return [
            'Best Season' => 'Oct to Mar',
            'Ideal Duration' => '4 to 6 days',
            'Trip Style' => 'Family, Couple, Solo',
            'Starting Budget' => 'Moderate',
        ];
    }

    private function buildSuggestedItinerary(Destination $destination): array
    {
        return [
            'Day 1' => 'Arrival and local market walk in ' . $destination->name,
            'Day 2' => 'Top sightseeing spots and local food experiences',
            'Day 3' => 'Signature activity plus sunset viewpoint',
            'Day 4' => 'Flexible day for shopping and hidden gems',
        ];
    }

    private function buildFaqs(Destination $destination, string $title): array
    {
        return [
            [
                'question' => 'What is the best time to visit ' . $destination->name . '?',
                'answer' => 'The most comfortable period is usually between October and March for pleasant weather and easier sightseeing.',
            ],
            [
                'question' => 'How many days are enough for ' . $destination->name . '?',
                'answer' => 'Most travelers enjoy a balanced trip in 4 to 6 days depending on pace and activity preferences.',
            ],
            [
                'question' => 'Is this guide suitable for first-time travelers?',
                'answer' => 'Yes. ' . $title . ' is written to help first-time travelers plan routes, stays, and daily plans with clarity.',
            ],
        ];
    }
}
