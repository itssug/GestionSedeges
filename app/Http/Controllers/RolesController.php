<?php

namespace App\Http\Controllers;

use App\Models\roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles= roles::all();
        return view('admin.roles.index',['roles'=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'cod_rol'=>'required',
            'nombre_rol'=>'required'
         ]);

        $roles= new roles();
        $roles->cod_rol=$request->input('cod_rol');
        $roles->nombre_rol=$request->input('nombre_rol');
        $roles->estado_rol = 1;

        //      nombre de la tabla          id del fomrs
        $roles->save();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol creado correctamente.');



    }

    /**
     * Display the specified resource.
     */
    public function show(roles $roles)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $rol=roles::find($id);

        return view('admin.roles.edit',['rol'=>$rol]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cod_rol'=>'required',
            'nombre_rol'=>'required'
        ]);

        $roles= roles::find($id);
        $roles->cod_rol=$request->input('cod_rol');
        $roles->nombre_rol=$request->input('nombre_rol');
        //      nombre de la tabla          id del fomrs
        $roles->save();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Rol creado correctamente.');
        //return view("roles.message", ['msg'=>"registro guardado"]);
        //revisa para ver si lo pones
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) { $rol = roles::find($id);

        if ($rol) {
            // Alternar el estado entre 1 y 0
            $rol->estado_rol = $rol->estado_rol ? 0 : 1;
            $rol->save();
        }

        return redirect('roles')->with('success', 'Estado del rol actualizado.');

}}
