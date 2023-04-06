<?php

namespace App\Filament\Resources\VehicleConstructorResource\Pages;

use App\Filament\Resources\VehicleConstructorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVehicleConstructor extends EditRecord
{
    protected static string $resource = VehicleConstructorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
