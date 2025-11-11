<?php

namespace App\Filament\Widgets;

use App\Models\Miembro;
use Filament\Widgets\ChartWidget;

class MiembrosPorRolChart extends ChartWidget
{
    protected static ?string $heading = 'Distribución por Rol';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '30s';

    protected static string $color = 'info';

    protected function getData(): array
    {
        $azules = Miembro::where('rol', 'Mariposa Azul')->count();
        $padres = Miembro::where('rol', 'Mariposa Padre/Madre')->count();
        $ejecutivas = Miembro::where('rol', 'Mariposa Ejecutiva')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Miembros por Rol',
                    'data' => [$azules, $padres, $ejecutivas],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',  // Blue for Azul
                        'rgba(168, 85, 247, 0.8)',  // Purple for Padre/Madre
                        'rgba(251, 191, 36, 0.8)',  // Yellow for Ejecutiva
                    ],
                    'borderColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(168, 85, 247)',
                        'rgb(251, 191, 36)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'Mariposa Azul (' . $azules . ')',
                'Mariposa Padre/Madre (' . $padres . ')',
                'Mariposa Ejecutiva (' . $ejecutivas . ')',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'animation' => [
                'animateScale' => true,
                'animateRotate' => true,
            ],
        ];
    }
}
