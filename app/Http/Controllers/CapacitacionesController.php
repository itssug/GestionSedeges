<?php

namespace App\Http\Controllers;

use App\Models\capacitaciones;
use App\Models\centros;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CapacitacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     // Obtener todas las capacitaciones
    //     $capacitaciones = capacitaciones::all();
    //     return view('admin.capacitaciones.index', compact('capacitaciones'));
    // }

    public function pdf()
    {

        $capacitaciones = capacitaciones::all();
        $pdf = Pdf::loadView('admin.capacitaciones.pdf', \compact('capacitaciones'));
        return $pdf->stream();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.capacitaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'duracion' => 'required|integer',
            'modalidad' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',

            'sesiones' => 'required|array',
            'sesiones.*.tema' => 'required|string|max:255',
            'sesiones.*.fecha' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $fechaSesion = strtotime($value);
                    $fechaInicio = strtotime($request->input('fecha_inicio'));
                    $fechaFin = strtotime($request->input('fecha_fin'));
                    if ($fechaSesion < $fechaInicio || $fechaSesion > $fechaFin) {
                        $fail("La fecha de la sesión ($value) debe estar entre la fecha de inicio y fin de la capacitación.");
                    }
                },
            ],
            'sesiones.*.hora_inicio' => 'required|date_format:H:i',
            'sesiones.*.hora_fin' => 'required|date_format:H:i',
            'sesiones.*.duracion' => 'required|integer|min:1',
        ]);

        // Crear capacitación
        $capacitacion = capacitaciones::create($request->only([
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'duracion',
            'modalidad',
            'institucion',
            'direccion',
            'estado'
        ]));

        // Insertar sesiones relacionadas
        foreach ($request->input('sesiones') as $sesion) {
            $capacitacion->sesiones()->create([
                'tema' => $sesion['tema'],
                'fecha' => $sesion['fecha'],
                'hora_inicio' => $sesion['hora_inicio'],
                'hora_fin' => $sesion['hora_fin'],
                'duracion' => $sesion['duracion'],
            ]);
        }
        return redirect()->route('capacitaciones.index')
            ->with('success', 'Capacitación y sesiones creadas con éxito.');
    }

    public function ObtenerSesiones($id)
    {
        $capacitacion = Capacitaciones::with('sesiones')->findOrFail($id);
        $sesiones = $capacitacion->sesiones->map(function ($sesion) {
            return [
                'id' => $sesion->id,
                'tema' => $sesion->tema,
                'fecha' => $sesion->fecha,
                'hora_inicio' => $sesion->hora_inicio,
                'hora_fin' => $sesion->hora_fin,
                'duracion' => $sesion->duracion
            ];
        });
       // dd($sesiones);

        return response()->json($sesiones);
    }

//     public function ObtenerSesiones($id)
// {
//     $capacitacion = Capacitaciones::findOrFail($id);

//     // Asegúrate de incluir todos los campos necesarios
//     $sesiones = $capacitacion->sesiones;

//     return response()->json($sesiones);
// }

    /**
     * Display the specified resource.
     */
    public function show(capacitaciones $capacitaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $capacitacion = Capacitaciones::findOrFail($id);
        return view('admin.capacitaciones.edit', compact('capacitacion'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    try {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'duracion' => 'required|integer|min:1',
            'modalidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'institucion' => 'required|string|max:255',
            'estado' => 'nullable|string|max:255',
            'sesiones' => 'array',
            'sesiones.*.id' => 'nullable|integer|exists:sesiones,id',
            'sesiones.*.tema' => 'required|string|max:255',  // validación tema
            'sesiones.*.fecha' => 'required|date',
            'sesiones.*.hora_inicio' => 'required',
            'sesiones.*.hora_fin' => 'required',
        ]);

        $capacitacion = Capacitaciones::findOrFail($id);

        // Actualizar datos generales
        $capacitacion->update($request->only([
            'nombre',
            'descripcion',
            'fecha_inicio',
            'fecha_fin',
            'duracion',
            'modalidad',
            'institucion',
            'direccion',
            'estado',
        ]));

        $sesionesInput = $request->input('sesiones', []);
        $idsFormulario = collect($sesionesInput)->pluck('id')->filter()->toArray();

        // Eliminar sesiones que ya no están en el formulario
        $capacitacion->sesiones()->whereNotIn('id', $idsFormulario)->delete();

        foreach ($sesionesInput as $sesionData) {
            // Calcular duración en minutos (hora_fin - hora_inicio)
            $horaInicio = $sesionData['hora_inicio'];
            $horaFin = $sesionData['hora_fin'];
            list($h1, $m1) = explode(':', $horaInicio);
            list($h2, $m2) = explode(':', $horaFin);
            $duracionMin = (($h2 * 60) + $m2) - (($h1 * 60) + $m1);
            if ($duracionMin < 0) $duracionMin = 0; // seguridad

            if (isset($sesionData['id'])) {
                // Actualizar sesión existente
                $capacitacion->sesiones()->where('id', $sesionData['id'])->update([
                    'fecha' => $sesionData['fecha'],
                    'hora_inicio' => $horaInicio,
                    'hora_fin' => $horaFin,
                    'duracion' => $duracionMin,
                    'tema' => $sesionData['tema'],  // <-- agregar tema
                ]);
            } else {
                // Crear nueva sesión
                $capacitacion->sesiones()->create([
                    'fecha' => $sesionData['fecha'],
                    'hora_inicio' => $horaInicio,
                    'hora_fin' => $horaFin,
                    'duracion' => $duracionMin,
                    'tema' => $sesionData['tema'],  // <-- agregar tema
                ]);
            }
        }

        return redirect()->route('capacitaciones.index')->with('success', 'Capacitación actualizada con éxito.');

    } catch (\Exception $e) {
        return redirect()->route('capacitaciones.index')->with('error', 'Error al actualizar la capacitación: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $capacitacion = capacitaciones::findOrFail($id);
        $capacitacion->estado = !$capacitacion->estado;
        $capacitacion->save();
        return redirect()->route('capacitaciones.index')->with('success', 'Estado de la capacitación actualizado con éxito.');
    }

    public function capacitacionesActivos()
    {
        $capacitaciones = capacitaciones::where('estado', 1)->get();

        $pdf = Pdf::loadView('admin.capacitaciones.reportes_activos', compact('capacitaciones'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('capacitaciones_activos.pdf');
    }

    //REPORTE NNAS INACTIVOS
    public function capacitacionesInactivos()
    {
        $capacitaciones = capacitaciones::where('estado', 0)->get();
        $pdf = Pdf::loadView('admin.capacitaciones.reportes_inactivos', compact('capacitaciones'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('capacitaciones_inactivos.pdf');
    }

    // Mostrar lista con filtros aplicables

    public function index(Request $request)
    {
        $query = Capacitaciones::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('institucion')) {
            $query->where('institucion', 'like', '%' . $request->institucion . '%');
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', 'like', '%' . $request->modalidad . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $capacitaciones = $query->paginate(30);

        return view('admin.capacitaciones.index', compact('capacitaciones'));
    }

    // este se usa para filtrar y generar un PDF con los resultados de la búsqueda
    public function filtrarPdf(Request $request)
    {
        $query = Capacitaciones::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('institucion')) {
            $query->where('institucion', 'like', '%' . $request->institucion . '%');
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', 'like', '%' . $request->modalidad . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin]);
        }

        $capacitaciones = $query->get();

        $pdf = PDF::loadView('admin.capacitaciones.pdf', compact('capacitaciones'));
        return $pdf->stream('capacitaciones-filtradas.pdf');
    }
}
