<?php

namespace App\Filament\Resources\VehicleSpecificationResource\Pages;

use App\Filament\Resources\VehicleSpecificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

class ListVehicleSpecifications extends ListRecords
{
    protected static string $resource = VehicleSpecificationResource::class;

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
