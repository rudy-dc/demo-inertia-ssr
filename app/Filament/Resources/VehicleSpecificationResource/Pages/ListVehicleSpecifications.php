<?php

namespace App\Filament\Resources\VehicleSpecificationResource\Pages;

use App\Filament\Resources\VehicleSpecificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

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
}
