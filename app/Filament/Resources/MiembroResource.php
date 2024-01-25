<?php

namespace App\Filament\Resources;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Filament\Resources\MiembroResource\Pages;
use App\Filament\Resources\MiembroResource\RelationManagers;
use App\Models\Miembro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MiembroResource extends Resource
{
    protected static ?string $model = Miembro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\TextInput::make('password')
                ->label('Contraseña')
                ->disabled(),
                Forms\Components\Select::make('lider_grupo_id')
                    ->label('Líder de Grupo')
                    ->options(Miembro::all()->pluck('nombreCompleto', 'miembros_id'))
                    ->nullable()
                    ->searchable(),
                Forms\Components\TextInput::make('nombres')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellidos')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dni')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provincia')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Toggle::make('miembros_estado')
                    ->required(),
                Forms\Components\Select::make('rol')
                    ->options([
                        'Mariposa Azul' => 'Mariposa Azul',
                        'Mariposa Madre' => 'Mariposa Madre',
                        'Mariposa Reina' => 'Mariposa Reina',
                    ])
                    ->default('Mariposa Azul')
                    ->disabled(),
            ]);

    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('liderGrupo.nombreCompleto')->label('Líder de Grupo'),
            Tables\Columns\TextColumn::make('nombres')->searchable(),
            Tables\Columns\TextColumn::make('apellidos')->searchable(),
            Tables\Columns\TextColumn::make('dni')->searchable(),
            Tables\Columns\TextColumn::make('provincia')->searchable(),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('phone')->searchable(),
            Tables\Columns\IconColumn::make('miembros_estado')->boolean(),
            Tables\Columns\TextColumn::make('rol')->label('Rol'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('password')->label('Contraseña'),
            // ... otras columnas ...
        ])
        // ... definiciones de columnas, filtros, acciones, etc. ...
        ->query(function ($query) {
            $usuarioAutenticado = auth()->user();
            $miembroAutenticado = $usuarioAutenticado->miembro;

            switch ($miembroAutenticado->rol) {
                case 'Mariposa Reina':
                    // Incluir 'Mariposas Madres' y sus 'Mariposas Azules'
                    return $query->where(function ($query) use ($miembroAutenticado) {
                        $query->where('lider_grupo_id', $miembroAutenticado->id)
                              ->orWhereHas('liderGrupo', function ($query) use ($miembroAutenticado) {
                                  $query->where('lider_grupo_id', $miembroAutenticado->id)
                                        ->where('rol', 'Mariposa Madre');
                              });
                    });
                case 'Mariposa Madre':
                    // Incluir solo 'Mariposas Azules' referidas por esta 'Mariposa Madre'
                    return $query->where('lider_grupo_id', $miembroAutenticado->id)
                                 ->where('rol', 'Mariposa Azul');
                case 'Mariposa Azul':
                    // 'Mariposas Azules' podrían ver solo sus propios detalles o seguir otra regla
                    return $query->where('id', $miembroAutenticado->id);
                default:
                    // Restricción por defecto para otros roles o usuarios no autenticados
                    return $query->where('id', 0); // No muestra ningún registro
            }
        })
        ->filters([
                // Puedes añadir filtros si son necesarios
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
            // Define tus relaciones aquí si son necesarias
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMiembros::route('/'),
            'create' => Pages\CreateMiembro::route('/create'),
            'edit' => Pages\EditMiembro::route('/{record}/edit'),
        ];
    }
}

