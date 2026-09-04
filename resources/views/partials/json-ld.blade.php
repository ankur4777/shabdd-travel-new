@php
    $pageNames = [
        'home' => 'SHABDD Travel | Domestic and International Tour Packages',
        'contact' => 'Contact SHABDD Travel',
        'about' => 'About SHABDD Travel',
        'blog.index' => 'SHABDD Travel Blog',
        'careers.index' => 'Careers at SHABDD Travel',
        'destinations.index' => 'Travel Destinations | SHABDD Travel',
        'packages.index' => 'Tour Packages | SHABDD Travel',
        'reviews.index' => 'Traveler Reviews | SHABDD Travel',
        'international-tours.index' => 'International Tours | SHABDD Travel',
        'all-domestic' => 'Domestic Tours | SHABDD Travel',
        'terms.conditions' => 'Terms and Conditions | SHABDD Travel',
        'privacy.policy' => 'Privacy Policy | SHABDD Travel',
        'copyright.policy' => 'Copyright Policy | SHABDD Travel',
        'support' => 'Travel Support | SHABDD Travel',
        'travel-agent.join' => 'Join SHABDD Travel as a Travel Agent',
        'honeymoon' => 'Honeymoon Packages | SHABDD Travel',
        'family-trips' => 'Family Trips | SHABDD Travel',
        'religious' => 'Religious Tours | SHABDD Travel',
        'budget-friendly' => 'Budget Friendly Tours | SHABDD Travel',
        'beach-escapes' => 'Beach Escapes | SHABDD Travel',
        'hill-station-retreats' => 'Hill Station Retreats | SHABDD Travel',
        'island-getaways' => 'Island Getaways | SHABDD Travel',
        'desert-adventures' => 'Desert Adventures | SHABDD Travel',
        'under-25k' => 'Domestic Tours Under INR 25,000 | SHABDD Travel',
        'summer-vacation-specials' => 'Summer Vacation Specials | SHABDD Travel',
        'winter-vacation-specials' => 'Winter Vacation Specials | SHABDD Travel',
        'monsoon-specials' => 'Monsoon Vacation Specials | SHABDD Travel',
        'honeymoon-picks' => 'Honeymoon Tour Packages | SHABDD Travel',
        'international-tours.visa-assistance' => 'Visa Assistance | SHABDD Travel',
        'international-tours.group-departures' => 'Group Departures | SHABDD Travel',
        'international-tours.fixed-departure-dates' => 'Fixed Departure Dates | SHABDD Travel',
    ];

    $routeName = request()->route()?->getName();
    $pageName = $pageNames[$routeName] ?? 'SHABDD Travel';
    $pageUrl = url()->current();
    $logoUrl = asset('images/logo.png');

    if (isset($packagePageData)) {
        $pageName = $packagePageData['package_title'] . ' | SHABDD Travel';
    } elseif (isset($post)) {
        $pageName = $post['title'] . ' | SHABDD Travel Blog';
    } elseif (isset($career)) {
        $pageName = $career->title . ' | Careers at SHABDD Travel';
    } elseif (isset($journey)) {
        $pageName = $journey['name'] . ' | SHABDD Travel';
    } elseif (isset($destination, $destinationProfile)) {
        $pageName = $destination->name . ' Tours | SHABDD Travel';
    }

    $graph = [
        [
            '@type' => 'Organization',
            '@id' => url('/') . '#organization',
            'name' => 'SHABDD Travel',
            'url' => url('/'),
            'description' => 'SHABDD Travel provides domestic and international tour packages and travel support from Ghaziabad, Uttar Pradesh, India.',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'H.No. 232, Gali No. 14, Gulab Vatika, Loni',
                'addressLocality' => 'Ghaziabad',
                'addressRegion' => 'Uttar Pradesh',
                'postalCode' => '201102',
                'addressCountry' => 'IN',
            ],
            'telephone' => ['+91 7347673924', '+91 9643305791'],
            'email' => 'shabddtravel@gmail.com',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+91 7347673924',
                'email' => 'shabddtravel@gmail.com',
                'contactType' => 'customer support',
                'areaServed' => 'IN',
                'availableLanguage' => ['en', 'hi'],
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'name' => 'SHABDD Travel',
            'url' => url('/'),
            'publisher' => ['@id' => url('/') . '#organization'],
        ],
        [
            '@type' => 'WebPage',
            '@id' => $pageUrl . '#webpage',
            'url' => $pageUrl,
            'name' => $pageName,
            'isPartOf' => ['@id' => url('/') . '#website'],
        ],
    ];

    $breadcrumb = function (array $items): array {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->values()->map(fn ($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ])->all(),
        ];
    };

    if ($routeName === 'home') {
        $homeFaqs = [
            [
                'question' => 'How do I book a tour package?',
                'answer' => 'Choose your destination, share your travel dates, and our team will help confirm the itinerary, pricing, and payment steps.',
            ],
            [
                'question' => 'Can I customize my travel plan?',
                'answer' => 'Yes. Hotels, transfers, sightseeing, trip duration, and experiences can be adjusted around your budget and travel style.',
            ],
            [
                'question' => 'Do packages include flights?',
                'answer' => 'Some packages include flights and some are land-only. The package details and our sales team will clearly mention what is included.',
            ],
            [
                'question' => 'What support do I get during the trip?',
                'answer' => 'You get assistance for bookings, itinerary coordination, and on-trip travel support so your holiday stays smooth.',
            ],
        ];

        $graph[] = [
            '@type' => 'FAQPage',
            'mainEntity' => collect($homeFaqs)->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ])->values()->all(),
        ];
    } elseif (isset($packagePageData, $destination)) {
        $packageUrl = $pageUrl;
        $packageSchema = [
            '@type' => 'Product',
            '@id' => $packageUrl . '#package',
            'name' => $packagePageData['package_title'],
            'description' => strip_tags($packagePageData['overview_text']),
            'image' => array_values(array_filter(array_merge(
                [$packagePageData['main_image'] ?? null],
                $packagePageData['gallery_images'] ?? []
            ))),
            'brand' => ['@id' => url('/') . '#organization'],
            'category' => 'Travel package',
            'offers' => [
                '@type' => 'Offer',
                'url' => $packageUrl,
                'priceCurrency' => 'INR',
                'price' => (float) preg_replace('/[^0-9.]/', '', $packagePageData['starting_price']),
                'availability' => 'https://schema.org/InStock',
                'seller' => ['@id' => url('/') . '#organization'],
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => (float) $packagePageData['package_rating'],
                'reviewCount' => (int) $packagePageData['review_count'],
                'bestRating' => 5,
            ],
        ];

        $graph[] = $packageSchema;
        $graph[] = $breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $destination->name, 'url' => route('destinations.show', $destination)],
            ['name' => $packagePageData['package_title'], 'url' => $packageUrl],
        ]);
    } elseif (isset($post)) {
        $hasDestinationModel = isset($destination) && $destination instanceof \App\Models\Destination;
        $postDestinationName = $hasDestinationModel
            ? $destination->name
            : ($post['destination_name'] ?? '');
        $postDestinationUrl = $hasDestinationModel
            ? route('destinations.show', $destination)
            : route('blog.index');

        $graph[] = [
            '@type' => 'BlogPosting',
            '@id' => $pageUrl . '#article',
            'headline' => $post['title'],
            'description' => $post['excerpt'],
            'image' => [$post['image']],
            'datePublished' => $post['published_at'],
            'dateModified' => $post['published_at'],
            'author' => ['@type' => 'Person', 'name' => $post['author']],
            'publisher' => ['@id' => url('/') . '#organization'],
            'mainEntityOfPage' => ['@id' => $pageUrl . '#webpage'],
        ];
        $graph[] = $breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Blog', 'url' => route('blog.index')],
            ['name' => $postDestinationName, 'url' => $postDestinationUrl],
            ['name' => $post['title'], 'url' => $pageUrl],
        ]);
        if (!empty($post['faqs'])) {
            $graph[] = [
                '@type' => 'FAQPage',
                'mainEntity' => collect($post['faqs'])->map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq['question'] ?? '',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['answer'] ?? ''],
                ])->values()->all(),
            ];
        }
    } elseif (isset($career)) {
        $graph[] = [
            '@type' => 'JobPosting',
            '@id' => $pageUrl . '#job',
            'title' => $career->title,
            'description' => strip_tags(collect([
                $career->job_roles_responsibilities,
                $career->required_skills,
                $career->good_to_have,
            ])->flatten()->filter()->implode('. ')),
            'datePosted' => optional($career->created_at)->toDateString(),
            'employmentType' => $career->job_type,
            'hiringOrganization' => ['@id' => url('/') . '#organization'],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => $career->job_location],
            ],
        ];
    } elseif (isset($journey)) {
        $graph[] = [
            '@type' => 'TouristTrip',
            '@id' => $pageUrl . '#trip',
            'name' => $journey['name'],
            'description' => $journey['intro'] ?? $journey['dek'] ?? '',
            'image' => [$journey['hero_image'] ?? $journey['hero'] ?? ''],
            'touristType' => $journey['package_terms'] ?? [],
            'provider' => ['@id' => url('/') . '#organization'],
            'offers' => [
                '@type' => 'Offer',
                'url' => $pageUrl,
                'priceCurrency' => 'INR',
                'price' => (float) ($journey['starting_price'] ?? $journey['price'] ?? 0),
                'availability' => 'https://schema.org/InStock',
            ],
        ];
    } elseif (isset($destination, $destinationProfile)) {
        $graph[] = [
            '@type' => 'TouristDestination',
            '@id' => $pageUrl . '#destination',
            'name' => $destination->name,
            'description' => strip_tags((string) ($destination->short_description ?: $destination->about)),
            'image' => [$destination->image_url],
            'containedInPlace' => ['@type' => 'Country', 'name' => $destination->country],
        ];
        $graph[] = $breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Destinations', 'url' => route('destinations.index')],
            ['name' => $destination->name, 'url' => $pageUrl],
        ]);
    }
@endphp

<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
