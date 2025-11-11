<?php

namespace App\Http\Controllers;

use App\Models\Miembro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $miembro = $user->miembro;

        if (!$miembro) {
            abort(403, 'No tienes un perfil de miembro asociado.');
        }

        // Obtener estadísticas
        $referidosDirectos = $miembro->miembrosReferidos;
        $totalReferidos = $miembro->obtenerTodosIdsReferidos()->count();

        // Referidos por nivel de rol
        $mariposas_azules = $referidosDirectos->where('rol', 'Mariposa Azul')->count();
        $mariposas_padres = $referidosDirectos->where('rol', 'Mariposa Padre/Madre')->count();
        $mariposas_ejecutivas = $referidosDirectos->where('rol', 'Mariposa Ejecutiva')->count();

        // Progreso hacia el siguiente nivel
        $progreso = $this->calcularProgreso($miembro);

        return view('dashboard.index', compact(
            'miembro',
            'referidosDirectos',
            'totalReferidos',
            'mariposas_azules',
            'mariposas_padres',
            'mariposas_ejecutivas',
            'progreso'
        ));
    }

    public function referidos()
    {
        $user = Auth::user();
        $miembro = $user->miembro;

        if (!$miembro) {
            abort(403, 'No tienes un perfil de miembro asociado.');
        }

        $referidosDirectos = $miembro->miembrosReferidos()->with('municipio', 'provincia')->get();

        return view('dashboard.referidos', compact('miembro', 'referidosDirectos'));
    }

    public function perfil()
    {
        $user = Auth::user();
        $miembro = $user->miembro;

        if (!$miembro) {
            abort(403, 'No tienes un perfil de miembro asociado.');
        }

        return view('dashboard.perfil', compact('miembro', 'user'));
    }

    private function calcularProgreso($miembro)
    {
        $cantidadReferidos = $miembro->miembrosReferidos()->count();

        if ($miembro->rol === 'Mariposa Azul') {
            return [
                'nivel_actual' => 'Mariposa Azul',
                'proximo_nivel' => 'Mariposa Padre/Madre',
                'progreso' => min(($cantidadReferidos / 10) * 100, 100),
                'referidos_actuales' => $cantidadReferidos,
                'referidos_necesarios' => 10,
                'faltantes' => max(10 - $cantidadReferidos, 0)
            ];
        } elseif ($miembro->rol === 'Mariposa Padre/Madre') {
            $referidosCon10 = 0;
            foreach ($miembro->miembrosReferidos as $referido) {
                if ($referido->miembrosReferidos()->count() >= 10) {
                    $referidosCon10++;
                }
            }
            $totalReferidos = $miembro->miembrosReferidos()->count();

            return [
                'nivel_actual' => 'Mariposa Padre/Madre',
                'proximo_nivel' => 'Mariposa Ejecutiva',
                'progreso' => $totalReferidos > 0 ? ($referidosCon10 / $totalReferidos) * 100 : 0,
                'referidos_calificados' => $referidosCon10,
                'total_referidos' => $totalReferidos,
                'faltantes' => max($totalReferidos - $referidosCon10, 0)
            ];
        } else {
            return [
                'nivel_actual' => 'Mariposa Ejecutiva',
                'proximo_nivel' => 'Nivel Máximo',
                'progreso' => 100,
                'mensaje' => '¡Has alcanzado el nivel máximo!'
            ];
        }
    }
}
