<?php

namespace App\Http\Controllers;

use App\Models\asistencias;
use App\Models\adoptantes;
use App\Models\sesiones;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\capacitaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $asistencias = Asistencias::query()
            ->with(['adoptante.usuario', 'sesion.capacitacion']);

        if ($request->filled('desde')) {
            $asistencias->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $asistencias->whereDate('fecha', '<=', $request->hasta);
        }

        if ($request->filled('capacitacion_id')) {
            $asistencias->whereHas('sesion', function ($q) use ($request) {
                $q->where('capacitacion_id', $request->capacitacion_id);
            });
        }

        if ($request->filled('adoptante_id')) {
            $asistencias->where('adoptante_id', $request->adoptante_id);
        }

        if ($request->filled('asistencia')) {
            $asistencias->where('asistencia', $request->asistencia);
        }

        $asistencias = $asistencias->latest()->paginate(10);

        $capacitaciones = Capacitaciones::all();
        $adoptantes = Adoptantes::with('usuario')->get();

        return view('admin.asistencias.index', compact('asistencias', 'capacitaciones', 'adoptantes'));
    }


    public function obtenerSesiones($id)
    {
        $sesiones = Sesiones::where('capacitacion_id', $id)->get(['id', 'tema']);
        return response()->json($sesiones);
    }

    public function create()
    {
        $capacitaciones = Capacitaciones::where('estado', 1)->get();

        $adoptantes = Adoptantes::with('usuario') // Carga la relación users
            ->whereHas('usuario', function ($query) {
                $query->where('estado_usu', 1); // Solo usuarios activos
            })
            ->get();

        $sesiones = Sesiones::all();

        return view('admin.asistencias.create', compact('capacitaciones', 'adoptantes', 'sesiones'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'adoptante_id' => 'required|exists:adoptantes,id',
            'capacitacion_id' => 'required|exists:capacitaciones,id',
            // 'sesion_id' => 'required|exists:sesiones,id',
            // 'asistencia' => 'required|boolean',
        ]);

        $adoptante_id = $request->adoptante_id;
        $capacitacion_id = $request->capacitacion_id;

        // Obtener todas las sesiones de la capacitación
        $sesiones = Sesiones::where('capacitacion_id', $capacitacion_id)->get();

        foreach ($sesiones as $sesion) {
            Asistencias::create([
                'adoptante_id' => $adoptante_id,
                'sesion_id' => $sesion->id,
                'fecha' => now()->toDateString(),
                'asistencia' => 0 // No asistió por defecto
            ]);
        }

        return redirect()->route('asistencias.index')->with('success', 'Asistencias registradas correctamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(asistencias $asistencias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(asistencias $asistencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, asistencias $asistencias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asistencias $asistencia)
    {
        $asistencia->delete();

        return redirect()->route('asistencias.index')->with('success', 'Asistencia eliminada correctamente.');
    }

    public function toggle($id)
    {
        $asistencia = Asistencias::findOrFail($id);
        $asistencia->asistencia = !$asistencia->asistencia;
        $asistencia->save();

        return redirect()->back()->with('success', 'Estado de asistencia actualizado.');
    }

    public function filtrosPDF(Request $request)
    {
        $asistencias = Asistencias::query()
            ->with(['adoptante.usuario', 'sesion.capacitacion']);

        if ($request->filled('desde')) {
            $asistencias->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $asistencias->whereDate('fecha', '<=', $request->hasta);
        }

        if ($request->filled('capacitacion_id')) {
            $asistencias->whereHas('sesion', function ($q) use ($request) {
                $q->where('capacitacion_id', $request->capacitacion_id);
            });
        }

        if ($request->filled('adoptante_id')) {
            $asistencias->where('adoptante_id', $request->adoptante_id);
        }

        if ($request->filled('asistencia')) {
            $asistencias->where('asistencia', $request->asistencia);
        }

        $asistencias = $asistencias->orderByDesc('id')->get();


        $date = date('d/m/Y');

        $pdf = Pdf::loadView('admin.asistencias.pdf', compact('asistencias'));
        return $pdf->stream('asistencias.pdf'); // o ->download('archivo.pdf')

    }

     public function reporte1(Request $request)
    {
      $capacitacionId = $request->capacitacion_id;


        $sql = "
        SELECT
        users.name,
        users.apellidos,
        users.ruta_foto,
         users.cod_usu,
         capacitaciones.nombre
         AS capacitacion_nombre,
          capacitaciones.fecha_inicio,
          capacitaciones.fecha_fin,
          capacitaciones.modalidad,
          capacitaciones.institucion,
          capacitaciones.id AS capacitacion_id,
          sesiones.tema, sesiones.fecha,
          asistencias.asistencia FROM asistencias
          INNER JOIN adoptantes
          ON adoptantes.id = asistencias.adoptante_id
          INNER JOIN users
          ON users.id = adoptantes.user_id
          INNER JOIN sesiones
          ON sesiones.id = asistencias.sesion_id
          INNER JOIN capacitaciones
          ON capacitaciones.id = sesiones.capacitacion_id
           WHERE capacitacion_id = ?
    ";

        $reporte1 = collect(DB::select($sql, [$capacitacionId]));

    $capacitacion = $reporte1->first();

    $pdf = Pdf::loadView('admin.asistencias.pdf_reporte1', compact('reporte1', 'capacitacion'));

    return $pdf->stream('reporte1.pdf');
    }


    public function reporte2(Request $request)
    {
        $capacitacionId = $request->adoptante_id;

        $sql = "
        SELECT
        users.name,
        users.apellidos,
        users.ruta_foto,
         users.cod_usu,
         capacitaciones.nombre
         AS capacitacion_nombre,
          capacitaciones.fecha_inicio,
          capacitaciones.fecha_fin,
          capacitaciones.modalidad,
          capacitaciones.institucion,
          capacitaciones.id AS capacitacion_id,
          sesiones.tema, sesiones.fecha,
          asistencias.asistencia FROM asistencias
          INNER JOIN adoptantes
          ON adoptantes.id = asistencias.adoptante_id
          INNER JOIN users
          ON users.id = adoptantes.user_id
          INNER JOIN sesiones
          ON sesiones.id = asistencias.sesion_id
          INNER JOIN capacitaciones
          ON capacitaciones.id = sesiones.capacitacion_id
           WHERE adoptante_id = ?
    ";

        $reporte2 = DB::select($sql, [$capacitacionId]);
        // $reporte2 = collect($reporte2)->groupBy('id_adoptante');

        $pdf = Pdf::loadView('admin.asistencias.pdf_reporte2', compact('reporte2'));

        return $pdf->stream('reporte2.pdf');
    }





}
