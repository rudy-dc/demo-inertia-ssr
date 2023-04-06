<?php

namespace App\Filament\Resources\RunResource\Pages;

use App\Actions\CreateRun;
use App\Filament\Resources\RunResource;
use App\Models\Run;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRuns extends ManageRecords
{
    protected static string $resource = RunResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }
}
