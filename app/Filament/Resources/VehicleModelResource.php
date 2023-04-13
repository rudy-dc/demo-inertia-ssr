<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatcherResource\RelationManagers\CatchersRelationManager;
use App\Filament\Resources\VehicleModelResource\Pages;
use App\Filament\Resources\VehicleModelResource\RelationManagers;
use App\Models\VehicleModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VehicleModelResource extends Resource
{
    protected static ?string $model = VehicleModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Modèles';

    protected static ?string $navigationGroup = 'Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('vehicle_constructor_id')
                    ->relationship('vehicleConstructor', 'designation')
                    ->required(),
                Forms\Components\TextInput::make('designation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Toggle::make('is_visible'),
                Forms\Components\Select::make('category')
                    ->options(['SUV', 'Sportive', 'Hyper sportive']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_designation'),
                IconColumn::make('is_visible')
                    ->label('Visible SEO')
                    ->boolean()
            ])
            ->filters([
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
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListVehicleModels::route('/'),
            'create' => Pages\CreateVehicleModel::route('/create'),
            'edit' => Pages\EditVehicleModel::route('/{record}/edit'),
        ];
    }    
}
