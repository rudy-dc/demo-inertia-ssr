<?php

namespace App\Filament\Resources\VehicleSpecificationResource\Pages;

use App\Filament\Resources\VehicleSpecificationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleSpecification extends EditRecord
{
    protected static string $resource = VehicleSpecificationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
