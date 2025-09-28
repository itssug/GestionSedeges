<?php

namespace App\Http\Controllers;

use App\Models\tramites_adoptantes;
use App\Models\documentos_adoptantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Adoptantes;
use App\Models\Tramites;
use Illuminate\Http\Request;

class TramitesAdoptantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $adoptantes = DB::table('adoptantes as a')
    ->join('users as u', 'a.user_id', '=', 'u.id')
    ->select('a.id', 'u.name')
    ->orderBy('u.name')
    ->get();

    $query = Tramites_Adoptantes::with(['tramite', 'adoptante.usuario', 'documentoAdoptante']);

    // Filtro por nombre
    if ($request->filled('nombre')) {
        $query->whereHas('adoptante.usuario', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->nombre . '%');
        });
    }

    // Filtro por apellido
    if ($request->filled('descripcion')) {
        $query->whereHas('adoptante.usuario', function ($q) use ($request) {
            $q->where('apellido', 'like', '%' . $request->descripcion . '%');
        });
    }

    // Filtro por tipo de trámite
    if ($request->filled('tipo')) {
        $query->whereHas('tramite', function ($q) use ($request) {
            $q->where('tipo', $request->tipo);
        });
    }

    // Filtro por institución
    if ($request->filled('institucion')) {
        $query->whereHas('tramite', function ($q) use ($request) {
            $q->where('institucion', 'like', '%' . $request->institucion . '%');
        });
    }

    // Filtro por estado del documento
    if ($request->filled('estado')) {
        $query->whereHas('documentoAdoptante', function ($q) use ($request) {
            $q->where('estado', $request->estado);
        });
    }

    $tramitesAdoptantes = $query->paginate(10);

    return view('admin.tramites_adoptantes.index', [
        'tramitesAdoptantes' => $tramitesAdoptantes,
        'estado' => $request->estado,
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'tipo' => $request->tipo,
        'institucion' => $request->institucion,
        'adoptantes' => $adoptantes,
    ]);
}



    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $tramites = Tramites::all();

    // Solo adoptantes cuyo usuario esté activo, asumo que 'estado' es campo en usuario
    $adoptantes = Adoptantes::whereHas('usuario', function($query) {
        $query->where('estado_usu', 1);
    })->with('usuario')->get();

    return view('admin.tramites_adoptantes.create', [
        'tramites' => $tramites,
        'adoptantes' => $adoptantes,
    ]);
}
    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    try {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'url' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'fecha_emision' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_emision',
            'tramite_id' => 'required|exists:tramites,id',
            'adoptante_id' => 'required|exists:adoptantes,id',
        ]);

        $filePath = null;
        if ($request->hasFile('url') && $request->file('url')->isValid()) {
            $file = $request->file('url');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documentos_adoptantes', $fileName, 'public');
        }

        $documento = new Documentos_Adoptantes();
        $documento->nombre = $request->nombre;
        $documento->tipo = $request->tipo;
        $documento->descripcion = $request->descripcion;
        $documento->estado_doc = 1; // activo
        $documento->url = $filePath;
        $documento->fecha_emision = $request->fecha_emision ?? null;
        $documento->fecha_vencimiento = $request->fecha_vencimiento ?? null;
        $documento->adoptante_id = $request->adoptante_id;
        $documento->save();

        $tramiteAdoptante = new Tramites_Adoptantes();
        $tramiteAdoptante->documento_adoptante_id = $documento->id;
        $tramiteAdoptante->tramite_id = $request->tramite_id;
        $tramiteAdoptante->adoptante_id = $request->adoptante_id;
        $tramiteAdoptante->estado = 0; // pendiente
        $tramiteAdoptante->save();

        return redirect()->route('tramites_adoptantes.index')->with('success', 'Trámite y documento registrados correctamente');
    } catch (\Exception $e) {
        return redirect()->route('tramites_adoptantes.index')->with('error', 'Error al registrar el trámite: ' . $e->getMessage());
    }
}

public function cambiarEstado($id)
{
    try{
    $tramite = Tramites_Adoptantes::findOrFail($id);

    // Cambiar el estado
    $tramite->estado = $tramite->estado? 0 : 1; // Si es booleano, invierte el valor
    $tramite->save();


    return back()->with('success', 'Estado actualizado correctamente.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(tramites_adoptantes $tramites_adoptantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $tramiteAdoptante = Tramites_Adoptantes::with('documentoAdoptante')->findOrFail($id);
    // También puedes cargar relaciones que necesites para selects, etc.
    $tramites = Tramites::all();
    $adoptantes = Adoptantes::all();

    return view('admin.tramites_adoptantes.edit', compact('tramiteAdoptante', 'tramites', 'adoptantes'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'url' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'fecha_emision' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_emision',
            'tramite_id' => 'required|exists:tramites,id',
            'adoptante_id' => 'required|exists:adoptantes,id',
        ]);

        $tramiteAdoptante = Tramites_Adoptantes::findOrFail($id);
        $documento = Documentos_Adoptantes::findOrFail($tramiteAdoptante->documento_adoptante_id);

        if ($request->hasFile('url') && $request->file('url')->isValid()) {
            // Opcional: eliminar archivo viejo
            if ($documento->url) {
                Storage::disk('public')->delete($documento->url);
            }
            $file = $request->file('url');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documentos_adoptantes', $fileName, 'public');
            $documento->url = $filePath;
        }

        // Actualizar campos del documento
        $documento->nombre = $request->nombre;
        $documento->tipo = $request->tipo;
        $documento->descripcion = $request->descripcion;
        $documento->fecha_emision = $request->fecha_emision ?? null;
        $documento->fecha_vencimiento = $request->fecha_vencimiento ?? null;
        $documento->adoptante_id = $request->adoptante_id;
        $documento->save();

        // Actualizar el tramite adoptante
        $tramiteAdoptante->tramite_id = $request->tramite_id;
        $tramiteAdoptante->adoptante_id = $request->adoptante_id;
        $tramiteAdoptante->save();

        return redirect()->route('tramites_adoptantes.index')->with('success', 'Trámite y documento actualizados correctamente');
    } catch (\Exception $e) {
        return redirect()->route('tramites_adoptantes.index')->with('error', 'Error al actualizar el trámite: ' . $e->getMessage());
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tramites_adoptantes $tramites_adoptantes)
    {
        //
    }


public function filtrarPDF(Request $request)
{
    $query = Tramites_Adoptantes::with(['tramite', 'adoptante.usuario', 'documentoAdoptante']);

    // Filtro por nombre
    if ($request->filled('nombre')) {
        $query->whereHas('adoptante.usuario', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->nombre . '%');
        });
    }

    // Filtro por apellido (aunque el nombre del filtro sea "descripcion")
    if ($request->filled('descripcion')) {
        $query->whereHas('adoptante.usuario', function ($q) use ($request) {
            $q->where('apellido', 'like', '%' . $request->descripcion . '%');
        });
    }

    // Filtro por tipo de trámite
    if ($request->filled('tipo')) {
        $query->whereHas('tramite', function ($q) use ($request) {
            $q->where('tipo', $request->tipo);
        });
    }

    // Filtro por institución
    if ($request->filled('institucion')) {
        $query->whereHas('tramite', function ($q) use ($request) {
            $q->where('institucion', 'like', '%' . $request->institucion . '%');
        });
    }

    // Filtro por estado del documento
    if ($request->filled('estado')) {
        $query->whereHas('documentoAdoptante', function ($q) use ($request) {
            $q->where('estado', $request->estado);
        });
    }

    $tramitesAdoptantes = $query->get(); // Sin paginar para PDF

    $pdf = Pdf::loadView('admin.tramites_adoptantes.pdf', compact('tramitesAdoptantes'));

    return $pdf->stream('tramites_adoptantes.pdf');
}

public function reporteDocumentosAdoptantePDF($adoptanteId)
{
    // Obtener documentos del adoptante
    $documentos = DB::table('documentos_adoptantes as d')
    ->join('tramites_adoptantes as ta', 'd.id', '=', 'ta.documento_adoptante_id')
    ->join('tramites as tr', 'ta.tramite_id', '=', 'tr.id') // opcional si deseas más datos del trámite
    ->where('d.adoptante_id', $adoptanteId)
    ->select(
        'd.id',
        'd.nombre',
        'd.tipo',
        'tr.descripcion',
        'tr.estado',
        'd.url',
        'd.fecha_emision',
        'd.fecha_vencimiento',
        'd.created_at',
        'd.updated_at',
        'ta.tramite_id',
        'tr.tipo as tipo_tramite',
        'tr.institucion',
        'tr.descripcion as descripcion_tramite'
    )
    ->orderBy('d.nombre')
    ->get();

    // Obtener datos del adoptante con join a users
    $adoptante = DB::table('adoptantes as a')
        ->join('users as u', 'a.user_id', '=', 'u.id')
        ->where('a.id', $adoptanteId)
        ->select('a.id as adoptante_id', 'u.name', 'u.email', 'u.estado_usu', 'u.contacto', 'u.direccion')
        ->first();

    $pdf = PDF::loadView('admin.tramites_adoptantes.reportes_documentos_adoptante_pdf', compact('documentos', 'adoptante'));

    return $pdf->stream('documentos_adoptante_'.$adoptanteId.'.pdf');
}


}
