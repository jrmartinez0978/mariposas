<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MunicipioResource\Pages;
use App\Filament\Resources\MunicipioResource\RelationManagers;
use App\Models\Municipio;
use App\Models\Provincia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class MunicipioResource extends Resource
{
    protected static ?string $model = Municipio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->label('Nombre del Municipio')
                ->maxLength(255),
            Forms\Components\Select::make('provincia_id')
                ->label('Provincia')
                ->options(Provincia::all()->pluck('nombre', 'id'))
                ->searchable()
                ->required(),
            // ... otros campos si son necesarios ...
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Nombre del Municipio'),
                Tables\Columns\TextColumn::make('provincia.nombre')->label('Provincia'),
                TextColumn::make('miembros_count')->label('Número de Miembros')->sortable(),
                // ... otras columnas si son necesarias ...
            ])
            ->filters([
                // ... filtros si son necesarios ...
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // ... otras acciones si son necesarias ...
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                // ... otras acciones en masa si son necesarias ...
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('miembros');
    }

    public static function getRelations(): array
    {
        return [
            // ... relaciones si son necesarias ...
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMunicipios::route('/'),
            'create' => Pages\CreateMunicipio::route('/create'),
            'edit' => Pages\EditMunicipio::route('/{record}/edit'),
            // ... otras páginas si son necesarias ...
        ];
    }
}
