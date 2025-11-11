<?php

namespace App\Filament\Widgets;

use App\Models\Miembro;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimosMiembrosWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Últimos Miembros Registrados';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Miembro::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nombres')
                    ->label('Nombre Completo')
                    ->formatStateUsing(fn (Miembro $record) => $record->nombres . ' ' . $record->apellidos)
                    ->searchable(['nombres', 'apellidos'])
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-user')
                    ->iconColor('primary'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->iconColor('gray')
                    ->copyable()
                    ->copyMessage('Email copiado')
                    ->copyMessageDuration(1500),

                Tables\Columns\BadgeColumn::make('rol')
                    ->label('Rol')
                    ->colors([
                        'primary' => 'Mariposa Azul',
                        'warning' => 'Mariposa Padre/Madre',
                        'success' => 'Mariposa Ejecutiva',
                    ])
                    ->icons([
                        'heroicon-m-sparkles' => 'Mariposa Azul',
                        'heroicon-m-star' => 'Mariposa Padre/Madre',
                        'heroicon-m-trophy' => 'Mariposa Ejecutiva',
                    ]),

                Tables\Columns\TextColumn::make('provincia.nombre')
                    ->label('Provincia')
                    ->sortable()
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('gray'),

                Tables\Columns\IconColumn::make('estado')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-m-check-circle')
                    ->falseIcon('heroicon-m-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('miembrosReferidos_count')
                    ->label('Referidos')
                    ->counts('miembrosReferidos')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->description(fn (Miembro $record): string => $record->created_at->format('d/m/Y')),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated(false);
    }
}
