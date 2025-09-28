<?php

namespace App\Http\Controllers;

use App\Models\evaluacionesMedicas;
use App\Models\documentosNnas;
use App\Models\nnas;
use App\Models\personalSedeges;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EvaluacionesMedicasController extends Controller
{
    public function index()
    {
        $evaluaciones = EvaluacionesMedicas::with([
            'nna',
            'personalSedeges.usuario',
            'documentoNna',
        ])->get();

        return view('admin.evaluacionesMed.index', compact('evaluaciones'));
    }

    public function create()
    {
        $nnas = nnas::where('estado', 1)->get();

        $medicos = personalSedeges::with('rolesPersonal')
            ->where('estado', 1)
            ->whereHas('rolesPersonal', function ($query) {
                $query->where('id', 5); // Suponiendo que el rol 3 es Médico
            })
            ->get();

        return view('admin.evaluacionesMed.create', compact('nnas', 'medicos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nna_id' => 'required|exists:nnas,id',
            'personal_sedeges_id' => 'required|exists:personal_sedeges,id',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'observaciones' => 'nullable|string',
            'estado' => 'nullable|boolean',
            'fecha' => 'required|date|before_or_equal:today',
            'documento' => 'required|file|mimes:pdf,docx,jpg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('documento');
            $path = $file->store('documentosNnas', 'public');

            $fecha = Carbon::parse($validated['fecha'])->format('d-m-Y');

            $documento = documentosNnas::create([
                'nna_id' => $validated['nna_id'],
                'nombre' => 'Evaluación médica - ' . $fecha,
                'tipo' => 'Evaluación médica',
                'fecha_emision' => $validated['fecha'],
                'estado' => $request->has('estado') ? 1 : 0,
                'descripcion' => $validated['observaciones'] ?? '',
                'url' => $path,
            ]);

            evaluacionesMedicas::create([
                'nna_id' => $validated['nna_id'],
                'personal_sedeges_id' => $validated['personal_sedeges_id'],
                'diagnostico' => $validated['diagnostico'],
                'tratamiento' => $validated['tratamiento'],
                'observaciones' => $validated['observaciones'] ?? '',
                'fecha' => $validated['fecha'],
                'documentos_nna_id' => $documento->id,
            ]);

            DB::commit();

            return redirect()->route('evaluacionesMed.index')
                ->with('success', 'Evaluación médica y documento guardados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $evaluacion = evaluacionesMedicas::with([
            'nna',
            'personalSedeges.usuario',
            'documentoNna',
        ])->findOrFail($id);

        $nnas = nnas::where('estado', 1)->get();

        $medicos = personalSedeges::with('rolesPersonal')
            ->where('estado', 1)
            ->whereHas('rolesPersonal', function ($query) {
                $query->where('id', 5); // Rol de Médico
            })
            ->get();

        return view('admin.evaluacionesMed.edit', compact('evaluacion', 'nnas', 'medicos'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nna_id' => 'required|exists:nnas,id',
            'personal_sedeges_id' => 'required|exists:personal_sedeges,id',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'observaciones' => 'nullable|string',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'estado' => 'nullable|boolean',
            'documento' => 'nullable|file|mimes:pdf,docx,jpg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $evaluacion = evaluacionesMedicas::findOrFail($id);
            $documento = $evaluacion->documentoNna;

            if ($request->hasFile('documento')) {
                if ($documento && Storage::disk('public')->exists($documento->url)) {
                    Storage::disk('public')->delete($documento->url);
                }

                $file = $request->file('documento');
                $path = $file->store('documentosNnas', 'public');
                $documento->url = $path;
            }


            $documento->nna_id = $validated['nna_id'];
            $documento->nombre = 'Evaluación médica - ' . Carbon::now()->format('d/m/Y');
            $documento->tipo = 'Evaluación médica';
            $documento->fecha_emision = $validated['fecha_emision'];
            $documento->estado = $request->has('estado') ? 1 : 0;
            $documento->descripcion = $validated['observaciones'] ?? '';
            $documento->save();

            $evaluacion->nna_id = $validated['nna_id'];
            $evaluacion->personal_sedeges_id = $validated['personal_sedeges_id'];
            $evaluacion->diagnostico = $validated['diagnostico'];
            $evaluacion->tratamiento = $validated['tratamiento'];
            $evaluacion->observaciones = $validated['observaciones'] ?? '';
            $evaluacion->fecha = $validated['fecha_emision'];
            $evaluacion->save();

            DB::commit();

            return redirect()->route('evaluacionesMed.index')
                ->with('success', 'Evaluación médica y documento actualizados correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

   public function destroy($id)
{
    try {
        // Buscar la evaluación con su documento relacionado
        $evaluacion = evaluacionesMedicas::with('documentoNna')->findOrFail($id);

        // Verificar que tiene un documento
        if ($evaluacion->documentoNna) {
            // Cambiar el estado: si es 1 => 0, si es 0 => 1
            $nuevoEstado = $evaluacion->documentoNna->estado == 1 ? 0 : 1;
            $evaluacion->documentoNna->estado = $nuevoEstado;
            $evaluacion->documentoNna->save();

            return redirect()->route('evaluacionesMed.index')
                ->with('success', 'Estado del documento cambiado correctamente.');
        } else {
            return redirect()->route('evaluacionesMed.index')
                ->withErrors(['error' => 'La evaluación no tiene un documento asociado.']);
        }
    } catch (\Exception $e) {
        return redirect()->route('evaluacionesMed.index')
            ->withErrors(['error' => 'Error al cambiar estado: ' . $e->getMessage()]);
    }
}
}
