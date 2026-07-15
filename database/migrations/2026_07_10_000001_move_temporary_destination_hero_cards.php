<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        $disk = Storage::disk('public');

        DB::table('destinations')
            ->whereNotNull('hero_cards')
            ->get(['id', 'hero_cards'])
            ->each(function (object $destination) use ($disk): void {
                $cards = json_decode((string) $destination->hero_cards, true);

                if (! is_array($cards)) {
                    return;
                }

                $changed = false;

                foreach ($cards as &$card) {
                    $image = is_array($card) ? ($card['image'] ?? null) : null;

                    if (! is_string($image) || ! str_starts_with($image, 'livewire-file:')) {
                        continue;
                    }

                    $temporaryName = substr($image, strlen('livewire-file:'));
                    $temporaryPath = 'livewire-tmp/' . $temporaryName;

                    if (! $disk->exists($temporaryPath)) {
                        continue;
                    }

                    $permanentPath = 'destinations/hero-cards/' . $temporaryName;
                    $disk->copy($temporaryPath, $permanentPath);
                    $card['image'] = $permanentPath;
                    $changed = true;
                }

                unset($card);

                if ($changed) {
                    DB::table('destinations')
                        ->where('id', $destination->id)
                        ->update(['hero_cards' => json_encode($cards)]);
                }
            });
    }

    public function down(): void
    {
        // The migrated files are retained so rolling back cannot break saved destinations.
    }
};
