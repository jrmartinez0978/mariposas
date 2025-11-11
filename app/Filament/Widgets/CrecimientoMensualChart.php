<?php

namespace App\Filament\Widgets;

use App\Models\Miembro;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CrecimientoMensualChart extends ChartWidget
{
    protected static ?string $heading = 'Crecimiento de Miembros (Últimos 6 Meses)';

    protected static ?int $sort = 3;

    protected static ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');

            $count = Miembro::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Nuevos Miembros',
                    'data' => $data,
                    'fill' => 'start',
                    'backgroundColor' => 'rgba(236, 72, 153, 0.1)',
                    'borderColor' => 'rgb(236, 72, 153)',
                    'pointBackgroundColor' => 'rgb(236, 72, 153)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(236, 72, 153)',
                    'tension' => 0.4,
                    'borderWidth' => 3,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'animation' => [
                'duration' => 2000,
                'easing' => 'easeInOutQuart',
            ],
        ];
    }
}
