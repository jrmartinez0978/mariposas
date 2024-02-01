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
use Filament\Forms\Components\Select;
use App\Models\Provincia;
use App\Models\Municipio;

class MiembroResource extends Resource
{
    protected static ?string $model = Miembro::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

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
                Forms\Components\TextInput::make('cedula')
                    ->required()
                    ->unique(Miembro::class, 'cedula', ignoreRecord: true)
                    ->maxLength(255),
                    Select::make('provincia_id')
    ->label('Provincia')
    ->relationship('provincia', 'nombre') // Asegúrate de que 'nombre' es el campo correcto que quieres mostrar
    ->reactive() // Hace que este campo sea reactivo
    ->required(),

Select::make('municipio_id')
    ->label('Municipio')
    ->options(function (callable $get) {
        $provinciaId = $get('provincia_id');
        if (!$provinciaId) {
            return [];
        }

        return Municipio::where('provincia_id', $provinciaId)->pluck('nombre', 'id');
    })
    ->reactive() // Hace que este campo sea reactivo y se actualice cuando cambia 'provincia_id'
    ->required(),
                 Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(Miembro::class, 'email', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono')
                    ->tel()
                    ->maxLength(255),
                    // Agregar el mensaje de verificación de email
            Forms\Components\Placeholder::make('emailVerified')
            ->label('Estado de Verificación de Email')
            ->content(function ($record) {
                // Asegurarse de que el registro tiene un usuario asociado y que email_verified_at no es null
                if ($record && $record->user && $record->user->email_verified_at) {
                    return 'El email ha sido verificado.';
                } else {
                    return 'El email aún no ha sido verificado.';
                }
    }),
                Forms\Components\Toggle::make('estado')
                    ->required(),
                Forms\Components\Select::make('rol')
                    ->options([
                        'Mariposa Azul' => 'Mariposa Azul',
                        'Mariposa Padre/Madre' => 'Mariposa Padre/Madre',
                        'Mariposa Ejecutiva' => 'Mariposa Ejecutiva',
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
            Tables\Columns\TextColumn::make('cedula')->searchable(),
            Tables\Columns\TextColumn::make('provincia.nombre') ->label('Provincia'),
            Tables\Columns\TextColumn::make('municipio.nombre') ->label('Municipio'),
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('telefono')->searchable(),
            Tables\Columns\IconColumn::make('estado')->boolean(),
            Tables\Columns\TextColumn::make('rol')->label('Nivel'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('password')->label('Contraseña'),
            // ... otras columnas ...
        ])
        // ... definiciones de columnas, filtros, acciones, etc. ..
        ->filters([
                // Puedes añadir filtros si son necesarios
            ])
            ->actions([
                //Tables\Actions\Action::make('viewMembers')
                   // ->label('Ver Miembros')
                   // ->url(fn (Miembro $record): string => route('filament.resources.miembros.index', ['municipio' => $record->municipio_id]))
                   // ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            // Define tus relaciones aquí si son necesaria
        ];

    }

    public static function getEloquentQuery(): Builder {
        $query = parent::getEloquentQuery();

        // Filtrar miembros basados en la política
        if (!auth()->user()->can('viewAny', Miembro::class)) {
            $query->where('lider_grupo_id', auth()->user()->miembro->id);
        }

        return $query;
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
