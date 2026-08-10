<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Destination;
use App\Models\Package;
use Illuminate\Support\Facades\Storage;

class ExportKnowledgeBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-knowledge-base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export tourism data for AI knowledge base';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $documents = [];

        foreach (Destination::all() as $destination) {

            $content = implode("\n", array_filter([
                "Destination: {$destination->name}",
                "Country: {$destination->country}",
                "Category: {$destination->category}",
                "Theme: {$destination->theme}",
                "Tagline: {$destination->tagline}",
                "Short Description: {$destination->short_description}",
                "About: " . html_entity_decode(strip_tags($destination->about)),
                "Overview: " . html_entity_decode(strip_tags($destination->overview)),
                "Best Season: {$destination->best_season}",
                "Ideal Duration: {$destination->ideal_duration}",
                "Weather: {$destination->weather}",
                "Recommended Months: {$destination->recommended_months}",
                $destination->is_seasonal_journey ? 'Seasonal Journey: Yes' : null,
            ]));

            $documents[] = [
                'id' => $destination->id,
                'type' => 'destination',
                'title' => $destination->name,
                'content' => $content,
                'metadata' => [
                    'theme' => $destination->theme,
                    'country' => $destination->country,
                    'best_season' => $destination->best_season,
                    'is_seasonal_journey' => (bool) $destination->is_seasonal_journey,
                ]
            ];
        }

        foreach (Package::all() as $package) {

            $content = implode("\n", array_filter([
                "Package: {$package->title}",
                "Country: {$package->country}",
                "State: {$package->state}",
                "City: {$package->city}",
                "Theme: {$package->theme}",
                "Travel Style: {$package->travel_style}",
                "Duration: {$package->duration_text}",
                "Price: {$package->price} INR",
                "Description: " . html_entity_decode(strip_tags($package->description)),
                "Overview: " . html_entity_decode(strip_tags($package->detail_overview)),
                "Hotel: {$package->hotel_name}",
                "Hotel Category: {$package->hotel_category}",
                "Hotel Area: {$package->hotel_area}",
                "Highlights: " . implode(', ', $package->detail_highlights ?? []),
                "Inclusions: " . implode(', ', $package->inclusions ?? []),
                "Exclusions: " . implode(', ', $package->exclusions ?? []),
            ]));

            $documents[] = [
                'id' => $package->id,
                'type' => 'package',
                'title' => $package->title,
                'content' => $content,
                'metadata' => [
                    'theme' => $package->theme,
                    'country' => $package->country,
                    'city' => $package->city,
                    'duration' => $package->duration_text,
                ]
            ];
        }

        file_put_contents(
            storage_path('app/ai/knowledge_base.json'),
            json_encode(
                $documents,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );

        $this->info('Done');

        return self::SUCCESS;
    }
}
