<?php

namespace App\Http\Controllers;

use App\Models\documentosNnas;
use App\Models\evaluacionesMedicas;
use App\Models\evaluacionesPsicologicas;
use App\Models\nnas;
use Illuminate\Support\Facades\Storage;

use App\Models\personalSedeges;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EvaluacionesPsicologicasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluaciones = EvaluacionesPsicologicas::with([
            'nna',
            'personalSedeges.usuario',
            'documentoNna',
        ])->get();

        return view('admin.evaluacionesPsi.index', compact('evaluaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $nnas = nnas::where('estado', 1)->get();
         $psicologos = PersonalSedeges::with('rolesPersonal')
        ->where('estado', 1)
        ->whereHas('rolesPersonal', function ($query) {
            $query->where('id', 4);
        })
        ->get();

        return view('admin.evaluacionesPsi.create', compact('nnas', 'psicologos'));
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    $validated = $request->validate([
        'nna_id' => 'required|exists:nnas,id',
        'personal_sedeges_id' => 'required|exists:personal_sedeges,id',
        'diagnostico' => 'required|string',
        'recomendaciones' => 'required|string',
        'observaciones' => 'nullable|string',
        'estado' => 'nullable|boolean',
        'fecha'=>'required|date|before_or_equal:today',
        'documento' => 'required|file|mimes:pdf,docx,jpg,png|max:5120',
    ]);

    DB::beginTransaction();

    try {
        // GUARDAR EN DOCUMENTOS NNAs
        $file = $request->file('documento');
        $path = $file->store('documentosNnas', 'public');

        $documento = documentosNnas::create([
            'nna_id' => $validated['nna_id'],
            'nombre' => 'Evaluación psicológica - ' . Carbon::now()->format('d/m/Y'),
            'tipo' => 'Evaluación psicológica',
            'fecha_emision' => $validated['fecha'],
            'estado' => $request->has('estado') ? 1 : 0,
            'descripcion' => $validated['observaciones'] ?? '',
            'url' => $path,
        ]);

        // 2. Crear evaluación psicológica, asignando el documento creado
        $evaluacion = EvaluacionesPsicologicas::create([
            'nna_id' => $validated['nna_id'],
            'personal_sedeges_id' => $validated['personal_sedeges_id'],
            'diagnostico' => $validated['diagnostico'],
            'recomendaciones' => $validated['recomendaciones'],
            'observaciones' => $validated['observaciones'] ?? null,
            'fecha' => $validated['fecha'], // <--- agregar esta línea
            'documentos_nna_id' => $documento->id, // FK en evaluacion a documento
        ]);

        DB::commit();

        return redirect()->route('evaluacionesPsi.index')
            ->with('success', 'Evaluación psicológica y documento guardados correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
    }
}



    /**
     * Display the specified resource.
     */
    public function show(evaluacionesPsicologicas $evaluacionesPsicologicas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    // Buscar la evaluación con sus relaciones
    $evaluacion = evaluacionesPsicologicas::with([
        'nna',
        'personalSedeges.usuario',
        'documentoNna',
    ])->findOrFail($id);

    // Obtener solo NNA con estado = 1
    $nnas = nnas::where('estado', 1)->get();

    // Obtener solo psicólogos con estado = 1 y rol id = 4
    $psicologos = PersonalSedeges::with('rolesPersonal')
        ->where('estado', 1)
        ->whereHas('rolesPersonal', function ($query) {
            $query->where('id', 4);
        })
        ->get();

    // Retornar vista con los datos
    return view('admin.evaluacionesPsi.edit', compact('evaluacion', 'nnas', 'psicologos'));
}


public function update(Request $request, $id)
{
    $validated = $request->validate([
        'nna_id' => 'required|exists:nnas,id',
        'personal_sedeges_id' => 'required|exists:personal_sedeges,id',
        'diagnostico' => 'required|string',
        'recomendaciones' => 'required|string',
        'observaciones' => 'nullable|string',
        'estado' => 'nullable|boolean',
        'fecha_emision' => 'required|date|before_or_equal:today',
        'documento' => 'nullable|file|mimes:pdf,docx,jpg,png|max:5120', // documento opcional en update
    ]);

    DB::beginTransaction();

    try {
        // Buscar la evaluación por id
        $evaluacion = EvaluacionesPsicologicas::findOrFail($id);

        // Obtener el documento relacionado
        $documento = $evaluacion->documentoNna; // asumiendo la relación 'documentoNna' está definida en el modelo EvaluacionesPsicologicas

        // Si hay un nuevo archivo, eliminar el anterior y guardar el nuevo
        if ($request->hasFile('documento')) {
            // Eliminar archivo anterior del storage si existe
            if ($documento && Storage::disk('public')->exists($documento->url)) {
                Storage::disk('public')->delete($documento->url);
            }

            // Guardar nuevo archivo
            $file = $request->file('documento');
            $path = $file->store('documentosNnas', 'public');

            // Actualizar ruta en documento
            $documento->url = $path;
        }

        // Actualizar datos del documento
        $documento->nna_id = $validated['nna_id'];
        $documento->nombre = 'Evaluación psicológica - ' . Carbon::now()->format('d/m/Y');
        $documento->tipo = 'Evaluación psicológica';
        $documento->fecha_emision = $validated['fecha_emision'];
        $documento->estado = $request->has('estado') ? 1 : 0;
        $documento->descripcion = $validated['observaciones'] ?? '';
        $documento->save();

        // Actualizar datos de la evaluación psicológica
        $evaluacion->nna_id = $validated['nna_id'];
        $evaluacion->personal_sedeges_id = $validated['personal_sedeges_id'];
        $evaluacion->diagnostico = $validated['diagnostico'];
        $evaluacion->recomendaciones = $validated['recomendaciones'];
        $evaluacion->observaciones = $validated['observaciones'] ?? null;
        $evaluacion->fecha = $validated['fecha_emision'];
        // No hace falta cambiar documentos_nna_id porque sigue siendo el mismo documento
        $evaluacion->save();

        DB::commit();

        return redirect()->route('evaluacionesPsi.index')
            ->with('success', 'Evaluación psicológica y documento actualizados correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
    }
}


   public function destroy($id)
{
    try {
        // Buscar la evaluación con su documento relacionado
        $evaluacion = EvaluacionesPsicologicas::with('documentoNna')->findOrFail($id);

        // Verificar que tiene un documento
        if ($evaluacion->documentoNna) {
            // Cambiar el estado: si es 1 => 0, si es 0 => 1
            $nuevoEstado = $evaluacion->documentoNna->estado == 1 ? 0 : 1;
            $evaluacion->documentoNna->estado = $nuevoEstado;
            $evaluacion->documentoNna->save();

            return redirect()->route('evaluacionesPsi.index')
                ->with('success', 'Estado del documento cambiado correctamente.');
        } else {
            return redirect()->route('evaluacionesPsi.index')
                ->withErrors(['error' => 'La evaluación no tiene un documento asociado.']);
        }
    } catch (\Exception $e) {
        return redirect()->route('evaluacionesPsi.index')
            ->withErrors(['error' => 'Error al cambiar estado: ' . $e->getMessage()]);
    }
}




}
