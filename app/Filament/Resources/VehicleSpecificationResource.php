<?php

namespace App\Filament\Resources;

use App\Actions\MergeCatchers;
use App\Filament\Resources\CatcherResource\RelationManagers\CatchersRelationManager;
use App\Filament\Resources\VehicleSpecificationResource\Pages;
use App\Filament\Resources\VehicleSpecificationResource\RelationManagers;
use App\Models\VehicleSpecification;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleSpecificationResource extends Resource
{
    protected static ?string $model = VehicleSpecification::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Modèles spécifiques';

    protected static ?string $navigationGroup = 'Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_constructor_id')
                    ->relationship('vehicleConstructor', 'designation')
                    ->required(),
                Forms\Components\Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'designation')
                    ->required(),
                Forms\Components\TextInput::make('designation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_visible')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vehicleConstructor.designation'),
                Tables\Columns\TextColumn::make('vehicleModel.designation'),
                Tables\Columns\TextColumn::make('designation'),
                IconColumn::make('is_visible')
                    ->label('Visible SEO')
                    ->boolean()
            ])
            ->filters([
                SelectFilter::make('vehicle_constructor_id')->relationship('vehicleConstructor', 'designation'),
                Filter::make('search')
                    ->form([
                        TextInput::make('designation')->label('Désignation'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['designation'],
                                fn (Builder $query, $value): Builder => $query->where('designation', 'like', "%$value%"),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('merge')
                    ->action(function (Collection $records, array $data): void {
                        MergeCatchers::run($records, $data['catcher']);
                    })
                    ->label('Merge')
                    ->form([
                        TextInput::make('catcher')
                            ->label('New specification name')
                            ->required()
                    ])
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            CatchersRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicleSpecifications::route('/'),
            'create' => Pages\CreateVehicleSpecification::route('/create'),
            'edit' => Pages\EditVehicleSpecification::route('/{record}/edit'),
        ];
    }    
}
