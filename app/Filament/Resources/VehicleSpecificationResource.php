<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleSpecificationResource\Pages;
use App\Filament\Resources\VehicleSpecificationResource\RelationManagers;
use App\Models\VehicleSpecification;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
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
                    ->relationship('vehicleConstructor', 'id')
                    ->required(),
                Forms\Components\Select::make('vehicle_model_id')
                    ->relationship('vehicleModel', 'id')
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
                //
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
            //
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
