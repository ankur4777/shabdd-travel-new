<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class InternationalTourController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::query()
            ->active()
            ->international()
            ->orderByDesc('is_trending')
            ->orderByDesc('rating')
            ->orderByDesc('id')
            ->get();

        $packageQuery = Package::query();
        $this->applyInternationalPackageScope($packageQuery);

        $packages = $packageQuery
            ->orderByDesc('featured')
            ->orderByDesc('rating')
            ->orderBy('price')
            ->get();

        $popularPackages = $packages
            ->filter(fn(Package $package) => strtolower(trim((string) $package->category)) === 'popular')
            ->values();

        return view('international-tours.index', compact('destinations', 'packages', 'popularPackages'));
    }

    public function visaAssistance(): View
    {
        return $this->supportPage([
            'slug' => 'visa-assistance',
            'title' => 'Visa Assistance',
            'eyebrow' => 'Travel help',
            'hero' => 'Clear visa guidance before you book the flight.',
            'lead' => 'Get document checklists, processing guidance and appointment support for popular international holiday destinations.',
            'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1800&q=85',
            'primary_cta' => 'Check visa support',
            'intro_title' => 'Less confusion at the paperwork stage.',
            'intro_text' => 'Visa rules can change by nationality, travel history and destination. We help you understand the route before you commit to dates.',
            'steps' => [
                ['title' => 'Profile review', 'text' => 'Share passport, travel dates and destination preference so we can confirm the right visa path.'],
                ['title' => 'Document checklist', 'text' => 'Receive a clear list for photos, financial documents, bookings and invitation details where needed.'],
                ['title' => 'Submission guidance', 'text' => 'Our team helps coordinate forms, appointment planning and status follow-up.'],
            ],
            'features' => [
                ['icon' => 'bi-passport', 'title' => 'Tourist visa guidance', 'text' => 'Support for short holiday and family travel applications.'],
                ['icon' => 'bi-file-earmark-check', 'title' => 'Document review', 'text' => 'Reduce avoidable errors before submission.'],
                ['icon' => 'bi-calendar-check', 'title' => 'Timeline planning', 'text' => 'Plan package booking around realistic processing windows.'],
            ],
            'faq' => [
                ['q' => 'Can you guarantee visa approval?', 'a' => 'No travel agency can guarantee approval. We help prepare the application carefully and explain the process clearly.'],
                ['q' => 'Can I book a package before visa approval?', 'a' => 'Yes, but our team will help choose safer booking terms when visa timing is uncertain.'],
            ],
        ]);
    }

    public function groupDepartures(): View
    {
        return $this->supportPage([
            'slug' => 'group-departures',
            'title' => 'Group Departures',
            'eyebrow' => 'Shared international journeys',
            'hero' => 'Travel with a group, without losing comfort.',
            'lead' => 'Fixed group journeys for families, friends, communities and corporate teams who want structured international travel.',
            'image' => 'https://images.unsplash.com/photo-1527631746610-bca00a040d60?w=1800&q=85',
            'primary_cta' => 'Plan a group',
            'intro_title' => 'Good groups need good rhythm.',
            'intro_text' => 'We build group tours around sensible pacing, hotel convenience, meal planning and local movement that works for everyone.',
            'steps' => [
                ['title' => 'Group brief', 'text' => 'Tell us group size, age mix, destination and preferred budget range.'],
                ['title' => 'Route design', 'text' => 'We recommend hotels, transfers, activities and optional free time windows.'],
                ['title' => 'Departure coordination', 'text' => 'Travellers receive clear timelines for payments, documents and final confirmations.'],
            ],
            'features' => [
                ['icon' => 'bi-people', 'title' => 'Family and friends', 'text' => 'Comfort-led itineraries for mixed age groups.'],
                ['icon' => 'bi-building-check', 'title' => 'Corporate groups', 'text' => 'Offsites, incentive trips and milestone celebrations.'],
                ['icon' => 'bi-bus-front', 'title' => 'Smooth movement', 'text' => 'Transfers and daily plans designed around group logistics.'],
            ],
            'faq' => [
                ['q' => 'What is the minimum group size?', 'a' => 'It depends on destination and hotel season, but most group pricing starts becoming useful from 10 travellers.'],
                ['q' => 'Can the group itinerary be private?', 'a' => 'Yes. We can build private group departures with custom hotels, meals and sightseeing.'],
            ],
        ]);
    }

    public function fixedDepartureDates(): View
    {
        return $this->supportPage([
            'slug' => 'fixed-departure-dates',
            'title' => 'Fixed Departure Dates',
            'eyebrow' => 'Scheduled tours',
            'hero' => 'Choose the date. Join the journey.',
            'lead' => 'Scheduled international tour batches with planned routes, shared logistics and clear inclusions.',
            'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1800&q=85',
            'primary_cta' => 'Ask for dates',
            'intro_title' => 'A simpler way to say yes to a trip.',
            'intro_text' => 'Fixed departures make international travel easier when you want a known date, a guided route and a ready group.',
            'steps' => [
                ['title' => 'Pick destination', 'text' => 'Choose from active international routes and preferred travel month.'],
                ['title' => 'Confirm batch', 'text' => 'We share available dates, inclusions, hotels and payment milestones.'],
                ['title' => 'Prepare to travel', 'text' => 'Visa, documents, flights and final travel notes are coordinated before departure.'],
            ],
            'features' => [
                ['icon' => 'bi-calendar2-week', 'title' => 'Planned dates', 'text' => 'Useful for school holidays, long weekends and festive breaks.'],
                ['icon' => 'bi-person-check', 'title' => 'Guided support', 'text' => 'Destination support from enquiry through departure.'],
                ['icon' => 'bi-cash-coin', 'title' => 'Clear costing', 'text' => 'Known inclusions make comparison and budgeting easier.'],
            ],
            'faq' => [
                ['q' => 'Are fixed departures always group tours?', 'a' => 'Most fixed departures are group-led, but private add-ons can often be arranged before or after the tour.'],
                ['q' => 'Can dates change?', 'a' => 'Dates are confirmed based on airline, hotel and group availability. We confirm the final schedule before payment milestones.'],
            ],
        ]);
    }

    private function supportPage(array $page): View
    {
        $packageQuery = Package::query();
        $this->applyInternationalPackageScope($packageQuery);

        return view('international-tours.support-page', [
            'page' => $page,
            'featuredPackages' => $packageQuery
                ->orderByDesc('featured')
                ->orderByDesc('rating')
                ->take(3)
                ->get(),
        ]);
    }

    private function applyInternationalPackageScope(Builder $query): void
    {
        if ($this->packageHasColumn('type')) {
            $query->whereRaw('LOWER(COALESCE(type, \'\')) = ?', ['international']);

            return;
        }

        if ($this->packageHasColumn('country')) {
            $query->where(function (Builder $countryQuery): void {
                $countryQuery
                    ->whereRaw('TRIM(COALESCE(country, \'\')) != ?', [''])
                    ->whereRaw('LOWER(TRIM(COALESCE(country, \'\'))) != ?', ['india']);
            });
        }
    }

    private function packageHasColumn(string $column): bool
    {
        static $columns;

        $columns ??= array_flip(Schema::getColumnListing('packages'));

        return isset($columns[$column]);
    }
}
