<?php

namespace App\Http\Controllers;

use App\Models\tramites;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TramitesController extends Controller
{
    public function index(Request $request)
    {
        $query = tramites::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->tipo . '%');
        }

        if ($request->filled('institucion')) {
            $query->where('institucion', 'like', '%' . $request->institucion . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $tramites = $query->orderBy('id', 'asc')->get();

        return view('admin.tramites.index', compact('tramites'));
    }

    public function create()
    {
        return view('admin.tramites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'institucion' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:100',
            'estado' => 'required|boolean',
        ]);

        tramites::create($request->all());

        return redirect()->route('tramites.index')->with('success', 'Trámite creado exitosamente.');
    }

    public function edit(tramites $tramite)
    {
        return view('admin.tramites.edit', compact('tramite'));
    }

    public function update(Request $request, tramites $tramite)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'institucion' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:100',
            'estado' => 'required|boolean',
        ]);

        $tramite->update($request->all());

        return redirect()->route('tramites.index')->with('success', 'Trámite actualizado correctamente.');
    }

    public function destroy(tramites $tramite)
    {
        $tramite->estado = $tramite->estado ? 0 : 1;
        $tramite->save();

        return redirect()->route('tramites.index')->with('success', 'Estado del trámite actualizado.');
    }

      public function filtrarPDF(Request $request)
    {
        $query = tramites::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', 'like', '%' . $request->tipo . '%');
        }

        if ($request->filled('institucion')) {
            $query->where('institucion', 'like', '%' . $request->institucion . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $tramites = $query->orderBy('id', 'desc')->get();

        $pdf = Pdf::loadView('admin.tramites.pdf', compact('tramites'));
        return $pdf->stream('tramites.pdf');
    }
}
