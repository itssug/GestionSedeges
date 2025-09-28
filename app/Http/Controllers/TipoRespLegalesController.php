<?php

namespace App\Http\Controllers;

use App\Models\TipoRespLegales;
use Illuminate\Http\Request;

class TipoRespLegalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoRespLegales::all();
        return view('admin.tipo_resp.index', ['tipos' => $tipos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tipo_resp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Cod_tipo' => 'required',
            'nombre_tipo' => 'required'
        ]);

        $tipos = new TipoRespLegales();
        $tipos->Cod_tipo = $request->input('Cod_tipo');
        $tipos->nombre_tipo = $request->input('nombre_tipo');
        $tipos->estado_tipo = 1;
        $tipos->save();

        return redirect()
            ->route('tipo_resp.index')
            ->with('success', 'Tipo de responsable creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoRespLegales $tipoRespLegales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tipo=TipoRespLegales::find($id);
       
        return view('admin.tipo_resp.edit',['tipo'=>$tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'Cod_tipo'=>'required',
            'nombre_tipo'=>'required'
        ]);

        $roles= TipoRespLegales::find($id);
        $roles->Cod_tipo=$request->input('Cod_tipo');
        $roles->nombre_tipo=$request->input('nombre_tipo');
        $roles->save();

        return redirect()
            ->route('tipo_resp.index')
            ->with('success', 'tipo de responsable creado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) { $tipo = TipoRespLegales::find($id);
    
        if ($tipo) {
            $tipo->estado_tipo = $tipo->estado_tipo? 0 : 1;
            $tipo->save();
        }
        
       return redirect('tipo_resp')->with('success', 'Estado del tipo de responsable actualizado.');
    }
}