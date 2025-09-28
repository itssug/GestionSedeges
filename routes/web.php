<?php

use App\Http\Controllers\AdoptantesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CentrosController;
use App\Http\Controllers\RolesPersonalController;
use App\Http\Controllers\TipoRespLegalesController;
use App\Http\Controllers\nnasController;
use App\Http\Controllers\RespLegalesController;
use App\Http\Controllers\PersonalSedegesController;
use App\Http\Controllers\CapacitacionesController;
use App\Http\Controllers\documentosNnasController;
use App\Http\Controllers\EvaluacionesMedicasController;
use App\Http\Controllers\EvaluacionesPsicologicasController;
use App\Http\Controllers\SesionesController;
use App\Http\Controllers\TramitesController;
use App\Http\Controllers\TramitesAdoptantesController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\dashboardController;
use App\Models\asistencias;
use App\Models\capacitaciones;
use App\Models\centros;
use App\Models\documentosNnas;
use App\Models\evaluacionesMedicas;
use App\Models\evaluacionesPsicologicas;
use App\Models\personalSedeges;

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
    return view('welcome');
});

Auth::routes();

Route::get('/centros/pdf', [centrosController::class, 'pdf'])->name('centros.pdf');
Route::get('/capacitaciones/pdf', [CapacitacionesController::class, 'pdf'])->name('capacitaciones.pdf');
Route::get('/adoptantes/pdf', [AdoptantesController::class, 'pdf'])->name('adoptantes.pdf');
Route::get('/usuarios/pdf', [AdoptantesController::class, 'pdf'])->name('usuarios.pdf');
Route::get('/nna/reporte/{id}', [nnasController::class, 'reporteNna'])->name('nna.reporte');
Route::get('/asistencias/pdf', [AsistenciasController::class, 'filtrosPDF'])->name('asistencias.pdf');
Route::get('asistencias/reporte1', [asistenciasController::class, 'reporte1'])->name('reportes.reporte1');
Route::get('asistencias/reporte2', [asistenciasController::class, 'reporte2'])->name('reportes.reporte2');
Route::get('/tramites_adoptantes/pdf', [TramitesAdoptantesController::class, 'filtrosPDF'])->name('tramites_adoptantes.pdf');
// web.php
Route::get('/nna/activos/pdf', [NnasController::class, 'nnaActivos'])->name('nnas.nna_activos.pdf');
Route::get('/nna/inactivos/pdf', [NnasController::class, 'nnaInactivos'])->name('nnas.nna_inactivos.pdf');
// Ruta para filtrar y mostrar resultados en la vista
Route::get('/nnas/filtrar', [NnasController::class, 'filtrar'])->name('nnas.filtrar');

// Ruta para generar el PDF con los filtros aplicados
Route::get('/nnas/filtrar-pdf', [NnasController::class, 'filtrarPdf'])->name('nnas.filtrar.pdf');


Route::patch('/asistencias/{id}/toggle', [AsistenciasController::class, 'toggle'])->name('asistencias.toggle');

Route::get('/centros/filtrar', [CentrosController::class, 'filtrar'])->name('centros.filtrar');
Route::get('/centros/filtrar-pdf', [CentrosController::class, 'filtrarPdf'])->name('centros.filtrar.pdf');
Route::get('/centros/reporte', [CentrosController::class, 'reporte1'])->name('centros.reporte');
Route::get('/resp_legales/pdf', [RespLegalesController::class, 'filtrarPDF'])->name('resp_legales.pdf');


Route::get('/tramites/filtrar-pdf', [tramitesController::class, 'filtrarPdf'])->name('tramites.filtrar.pdf');
Route::get('/tramites_adoptantes/filtrar-pdf', [TramitesAdoptantesController::class, 'filtrarPdf'])->name('tramites_adoptantes.pdf');
//Route::get('/capacitaciones', [CapacitacionesController::class, 'filtrar'])->name('capacitaciones.filtrar');
Route::get('/capacitaciones/filtrar-pdf', [CapacitacionesController::class, 'filtrarPdf'])->name('capacitaciones.filtrar.pdf');
Route::get('/personal/filtrar-pdf', [personalSedegesController::class, 'filtrarPdf'])->name('personal.filtrar.pdf');
Route::get('/nnas/{id}/reporte-pdf', [NnasController::class, 'reporteNna'])->name('nnas.reporteNna');

Route::get('/centros/activos/pdf', [centrosController::class, 'centroActivos'])->name('nnas.centros_activos.pdf');
Route::get('/centros/inactivos/pdf', [centrosController::class, 'centroInactivos'])->name('nnas.centros_inactivos.pdf');

Route::get('/capacitaciones/activos/pdf', [capacitacionesController::class, 'capacitacionesActivos'])->name('capacitaciones.capacitaciones_activos.pdf');
Route::get('/capacitaciones/inactivos/pdf', [capacitacionesController::class, 'capacitacionesInactivos'])->name('capacitaciones.capacitaciones_inactivos.pdf');

Route::get('/adoptantes/activos/pdf', [adoptantesController::class, 'adoptantesActivos'])->name('adoptantes.adoptantes_activos.pdf');
Route::get('/adoptantes/inactivos/pdf', [adoptantesController::class, 'adoptantesInactivos'])->name('adoptantes.adoptantes_inactivos.pdf');

Route::get('/adoptantes', [AdoptantesController::class, 'filtrar'])->name('adoptantes.index');
Route::get('/adoptantes/filtrar.pdf', [AdoptantesController::class, 'filtrarPdf'])->name('adoptantes.pdf');
Route::get('/adoptantes/pdf', [AdoptantesController::class, 'filtrarPDF'])->name('adoptantes.filtrarPDF');

Route::get('/capacitaciones/{id}/sesiones', [CapacitacionesController::class, 'ObtenerSesiones']);


Route::get('/capacitaciones/sesiones', [CapacitacionesController::class, 'ObtenerSesiones'])
     ->name('capacitaciones.obtenerSesiones');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('usuarios', UsersController::class);

Route::resource('roles', RolesController::class);

Route::resource('centros', CentrosController::class);

Route::resource('roles_personal', RolesPersonalController::class);

route::resource('tipo_resp', TipoRespLegalesController::class);

Route::resource('nnas', nnasController::class);

Route::resource('adoptantes', AdoptantesController::class);

Route::resource('resp_legales', RespLegalesController::class);

Route::resource('personal', personalSedegesController::class);

Route::resource('capacitaciones', capacitacionesController::class);

Route::resource('documentosNnas', documentosNnasController::class);

Route::resource('evaluacionesPsi', EvaluacionesPsicologicasController::class);

Route::resource('evaluacionesMed', EvaluacionesMedicasController::class);

Route::resource('tramites', tramitesController::class);

Route::get('/capacitaciones/{id}/sesiones', [CapacitacionesController::class, 'getSesiones'])->name('capacitaciones.sesiones');
Route::resource('sesiones', SesionesController::class);

Route::resource('asistencias', asistenciasController::class);

Route::get('/capacitaciones/{id}/sesiones', [AsistenciasController::class, 'obtenerSesiones']);

Route::get('/nna/filtrar', [NnasController::class, 'filtrar'])->name('nna.filtrar');
Route::resource('tramites_adoptantes', TramitesAdoptantesController::class);

Route::patch('/tramites-adoptantes/{id}/cambiar-estado', [TramitesAdoptantesController::class, 'cambiarEstado'])->name('tramites_adoptantes.cambiarEstado');

Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/tramites/documentos-adoptante/pdf/{adoptanteId}', [TramitesAdoptantesController::class, 'reporteDocumentosAdoptantePDF'])
    ->name('tramites.documentos_adoptante_pdf');

// Route::middleware(['auth', 'can:is-admin'])->group(function () {
//     Route::get('/admin', function () {
//         return view('admin.dashboard');
//     });
// });

// Route::middleware(['auth', 'can:is-adoptante'])->group(function () {
//     Route::get('/adoptantes', function () {
//         return view('adoptantes.dashboard');
//     });
// });

// Route::middleware(['auth', 'can:is-personal-sedeges'])->group(function () {
//     Route::get('/personal-sedeges', function () {
//         return view('personal-sedeges.dashboard');
//     });
// });

// Route::middleware(['auth', 'can:is-responsable-legal'])->group(function () {
//     Route::get('/responsables-legales', function () {
//         return view('responsables-legales.dashboard');
//     });
// });
