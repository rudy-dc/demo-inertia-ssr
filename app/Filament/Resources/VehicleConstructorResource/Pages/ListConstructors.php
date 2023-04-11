<?php

namespace App\Filament\Resources\VehicleConstructorResource\Pages;

use App\Console\Commands\ImportVehicles;
use App\Filament\Resources\VehicleConstructorResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

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
            Action::make('import')
                ->color('secondary')
                ->label('Import data')
                ->action('importData')
                ->requiresConfirmation(true),
            Actions\CreateAction::make(),
        ];
    }

    public function importData(): void
    {
        Artisan::call(ImportVehicles::class);
    }
}
