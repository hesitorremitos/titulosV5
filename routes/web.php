<?php

use App\Http\Controllers\DiplomaAcademicoController;
use App\Http\Controllers\DiplomasAcademicosController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TituloProfesionalController;
use App\Models\menciones\TPN;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
  return Inertia::render('DA', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
})->name('DA');

Route::get('/TPN', function () {
  return Inertia::render('TPN');
})->name('TPN');

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('dashboard')->group(function () {
  Route::resource('diploma-academico', DiplomaAcademicoController::class);
  Route::resource('titulo-profesional', TituloProfesionalController::class);
  Route::resource('mencion', PersonaController::class);
})->middleware(['auth']);



Route::post('mencion', function (Request $request) {
  $mencion = new TPN;
  $mencion->nombre = $request->mencion_tpn;
  $mencion->carrera_id = $request->carrera_tpn;
  $mencion->save();
  return $mencion;
})->name('tpn.store');

require __DIR__ . '/auth.php';
