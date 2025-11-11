<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiembroController;
use App\Http\Controllers\DashboardController;

Route::post('/miembro/{miembroId}/rol/{roleId}', [MiembroController::class, 'asignarRol']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('filament.panel.auth.login');
})->name('home');

// Dashboard de Mariposas (Requiere autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/mis-referidos', [DashboardController::class, 'referidos'])->name('dashboard.referidos');
    Route::get('/mi-perfil', [DashboardController::class, 'perfil'])->name('dashboard.perfil');
});
