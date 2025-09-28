<?php

namespace App\Http\Controllers;

use App\Models\documentosNnas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\nnas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


use function Ramsey\Uuid\v1;

class DocumentosNnasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtener datos de nnas y documenots
        $documentos = documentosNnas::with('nna')->get();
        return view('admin.documentos_nna.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $nnas = nnas::all();
        return view('admin.documentos_nna.create', compact('nnas'));
    }



    public function store(Request $request)
    {
        // Validación (puedes ajustarla a tus necesidades)
        $validatedData = $request->validate([
        'nna_id' => 'required|exists:nnas,id',
        'nombre' => 'required|string|min:3|max:255',
        'tipo' => 'required|string|in:Identificación,Educación,Salud,Legal,Otros',
        'descripcion' => 'nullable|string|max:500',
        'fecha_emision' => 'required|date|before_or_equal:today',
        'estado' => 'sometimes|boolean',
        'documento' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
    ], [
        'nna_id.required' => 'Debe seleccionar un niño, niña o adolescente.',
        'nna_id.exists' => 'El NNA seleccionado no existe en la base de datos.',
        'nombre.required' => 'El nombre del documento es obligatorio.',
        'nombre.min' => 'El nombre del documento debe tener al menos 3 caracteres.',
        'tipo.required' => 'Debe seleccionar un tipo de documento.',
        'tipo.in' => 'El tipo de documento seleccionado no es válido.',
        'fecha_emision.required' => 'La fecha de emisión es obligatoria.',
        'fecha_emision.date' => 'El formato de fecha no es válido.',
        'fecha_emision.before_or_equal' => 'La fecha de emisión no puede ser posterior a hoy.',
        'documento.required' => 'Debe adjuntar un archivo de documento.',
        'documento.file' => 'El documento debe ser un archivo válido.',
        'documento.mimes' => 'El documento debe ser de tipo: pdf, doc, docx, jpg, jpeg o png.',
        'documento.max' => 'El tamaño máximo del documento es de 5MB.',
    ]);
        // Guardar archivo
        if ($request->hasFile('documento') && $request->file('documento')->isValid()) {
            $file = $request->file('documento');

            // Nombre seguro con timestamp para evitar colisiones
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documentos_nna', $fileName, 'public');
        } else {
            return back()->with('error', 'Archivo inválido.');
        }

        //Guardar en la base de datos
        documentosNnas::create([
            'nna_id' => $request->nna_id,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'fecha_emision' => $request->fecha_emision,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado ?? false,
            'url' => $filePath, //
        ]);

        return redirect()->route('documentosNnas.index')->with('success', 'Documento guardado correctamente.');
    }





    /**
     * Display the specified resource.
     */
    public function show(documentosNnas $documentosNnas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $documento = documentosNnas::findOrFail($id);
        $nnas = Nnas::all(); // Para el select de NNA

        return view('admin.documentos_nna.edit', compact('documento', 'nnas'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
    {
        $documento = documentosNnas::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nna_id' => 'required|exists:nnas,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string|max:100',
            'fecha_emision' => 'required|date',
            'descripcion' => 'nullable|string',
            'estado' => 'nullable|boolean',
            'documento' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // max 5MB
        ]);

        // Actualizar campos
        $documento->nna_id = $validatedData['nna_id'];
        $documento->nombre = $validatedData['nombre'];
        $documento->tipo = $validatedData['tipo'];
        $documento->fecha_emision = $validatedData['fecha_emision'];
        $documento->descripcion = $validatedData['descripcion'] ?? null;
        $documento->estado = $request->has('estado') ? 1 : 0;

        // Manejo de archivo
        if ($request->hasFile('documento')) {
            // Eliminar archivo antiguo si existe
            if ($documento->url && Storage::exists($documento->url)) {
                Storage::delete($documento->url);
            }

            // Guardar archivo nuevo
            $path = $request->file('documento')->store('documentos_nna');
            $documento->url = $path;
        }

        $documento->save();

        return redirect()->route('documentosNnas.index')->with('success', 'Documento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) { $documento = documentosNnas::find($id);

        if ($documento) {
            $documento->estado = $documento->estado? 0 : 1;
            $documento->save();
        }

       return redirect('documentosNnas')->with('success', 'Estado del documento actualizado.');
    }
}
