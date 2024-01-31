<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvinciaResource\Pages;
use App\Filament\Resources\ProvinciaResource\RelationManagers;
use App\Models\Provincia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class ProvinciaResource extends Resource
{
    protected static ?string $model = Provincia::class;

    protected static ?string $navigationIcon = 'heroicon-o-map'; // Elige un icono adecuado

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->label('Nombre de la Provincia')
                    ->maxLength(255),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('nombre')->label('Nombre'),
            TextColumn::make('count_municipios')
                ->label('Número de Municipios')
                ->sortable(),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProvincias::route('/'),
            'create' => Pages\CreateProvincia::route('/create'),
            'edit' => Pages\EditProvincia::route('/{record}/edit'),
        ];
    }
}
