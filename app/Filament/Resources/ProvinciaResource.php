<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvinciaResource\Pages;
use App\Models\Provincia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
class ProvinciaResource extends Resource {
    protected static ?string $model = Provincia::class;

    protected static ?string $navigationIcon = 'heroicon-o-map'; // Elige un icono adecuado

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->label('Nombre de la Provincia')
                    ->maxLength(255),
                // ... otros campos si son necesarios ...
            ]);
    }

    public static function table(Table $table): Table {

        return $table
            ->columns([
                TextColumn::make('nombre')->searchable()->sortable(),
                TextColumn::make('municipios_count')->label('Número de Municipios')->sortable(),
                // ... otras columnas ...
            ])
            ->actions([
                EditAction::make(),
                // ... otras acciones ...
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('municipios_count'); // Ordenar por número de municipios
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()->withCount('municipios');
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListProvincias::route('/'),
            'create' => Pages\CreateProvincia::route('/create'),
            'edit' => Pages\EditProvincia::route('/{record}/edit'),
            // ... otras páginas si son necesarias ...
        ];
    }
}
