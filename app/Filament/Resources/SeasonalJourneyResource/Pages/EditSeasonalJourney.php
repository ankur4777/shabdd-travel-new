<?php
namespace App\Filament\Resources\SeasonalJourneyResource\Pages;
use App\Filament\Resources\SeasonalJourneyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeasonalJourney extends EditRecord
{
    protected static string $resource = SeasonalJourneyResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}