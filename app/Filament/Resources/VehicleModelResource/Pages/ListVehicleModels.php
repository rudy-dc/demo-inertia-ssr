<?php

namespace App\Filament\Resources\VehicleModelResource\Pages;

use App\Filament\Resources\VehicleModelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

class ListVehicleModels extends ListRecords
{
    protected static string $resource = VehicleModelResource::class;

    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [50, 100];
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }
}
