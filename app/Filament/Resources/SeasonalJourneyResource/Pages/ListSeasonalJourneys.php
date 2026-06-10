<?php
namespace App\Filament\Resources\SeasonalJourneyResource\Pages;
use App\Filament\Resources\SeasonalJourneyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeasonalJourneys extends ListRecords
{
    protected static string $resource = SeasonalJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}