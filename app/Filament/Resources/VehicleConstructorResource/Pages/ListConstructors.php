<?php

namespace App\Filament\Resources\VehicleConstructorResource\Pages;

use App\Filament\Resources\VehicleConstructorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicleConstructors extends ListRecords
{
    protected static string $resource = VehicleConstructorResource::class;

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
