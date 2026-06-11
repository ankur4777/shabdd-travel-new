<?php

namespace App\Filament\Resources\SeasonalJourneyResource\Pages;

use App\Filament\Resources\SeasonalJourneyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeasonalJourneys extends ListRecords
{
    protected static string $resource = SeasonalJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
