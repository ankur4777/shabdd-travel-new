<?php
<<<<<<< HEAD

namespace App\Filament\Resources\SeasonalJourneyResource\Pages;

use App\Filament\Resources\SeasonalJourneyResource;
use Filament\Actions\DeleteAction;
=======
namespace App\Filament\Resources\SeasonalJourneyResource\Pages;
use App\Filament\Resources\SeasonalJourneyResource;
use Filament\Actions;
>>>>>>> bece100e462339e104c682cd3bcc31f6f4c101d8
use Filament\Resources\Pages\EditRecord;

class EditSeasonalJourney extends EditRecord
{
    protected static string $resource = SeasonalJourneyResource::class;

    protected function getHeaderActions(): array
    {
<<<<<<< HEAD
        return [
            DeleteAction::make(),
        ];
    }
}
=======
        return [Actions\DeleteAction::make()];
    }
}
>>>>>>> bece100e462339e104c682cd3bcc31f6f4c101d8
