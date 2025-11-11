<?php

namespace App\Filament\Widgets;

use App\Models\Miembro;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MiembrosStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $totalMiembros = Miembro::count();
        $miembrosActivos = Miembro::where('estado', true)->count();
        $mariposasPadre = Miembro::where('rol', 'Mariposa Padre/Madre')->count();
        $mariposasEjecutivas = Miembro::where('rol', 'Mariposa Ejecutiva')->count();
        $miembrosHoy = Miembro::whereDate('created_at', today())->count();
        $miembrosSemana = Miembro::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        return [
            Stat::make('Total Miembros', number_format($totalMiembros))
                ->description($miembrosHoy . ' nuevos hoy')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 12, 8, 15, 22, 18, $miembrosHoy])
                ->color('success')
                ->extraAttributes([
                    'class' => 'hover:scale-105 transition-transform duration-300',
                ]),

            Stat::make('Miembros Activos', number_format($miembrosActivos))
                ->description(number_format(($miembrosActivos / max($totalMiembros, 1)) * 100, 1) . '% del total')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([65, 70, 75, 80, 85, 90, ($miembrosActivos / max($totalMiembros, 1)) * 100])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'hover:scale-105 transition-transform duration-300',
                ]),

            Stat::make('Mariposas Padre/Madre', number_format($mariposasPadre))
                ->description('Nivel intermedio')
                ->descriptionIcon('heroicon-m-sparkles')
                ->chart([5, 8, 12, 15, 18, 20, $mariposasPadre])
                ->color('warning')
                ->extraAttributes([
                    'class' => 'hover:scale-105 transition-transform duration-300',
                ]),

            Stat::make('Mariposas Ejecutivas', number_format($mariposasEjecutivas))
                ->description('Nivel máximo')
                ->descriptionIcon('heroicon-m-star')
                ->chart([1, 2, 3, 5, 7, 8, $mariposasEjecutivas])
                ->color('danger')
                ->extraAttributes([
                    'class' => 'hover:scale-105 transition-transform duration-300',
                ]),
        ];
    }
}
