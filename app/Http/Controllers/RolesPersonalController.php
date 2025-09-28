<?php

namespace App\Http\Controllers;

use App\Models\roles_personal;
use Illuminate\Http\Request;

class RolesPersonalController extends Controller
{
    
    public function index()
    {
        $roles = roles_personal::all();
        return view('admin.roles_personal.index', ['roles' => $roles]);
    }

   
    public function create() {

        return view('admin.roles_personal.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'cod_rol_per' => 'required',
            'nombre_rol_per' => 'required'
        ]);

        $roles = new roles_personal();
        $roles->cod_rol_per = $request->input('cod_rol_per');
        $roles->nombre_rol_per = $request->input('nombre_rol_per');
        $roles->estado = 1;
        $roles->save();

        return redirect()
            ->route('roles_personal.index')
            ->with('success', 'Rol creado correctamente.');
    }

   
    public function show(roles_personal $roles_personal)
    {
        //
    }

  
    public function edit($id)
    {
        $rol=roles_personal::find($id);
       
        return view('admin.roles_personal.edit',['rol'=>$rol]);
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'cod_rol_per'=>'required',
            'nombre_rol_per'=>'required'
        ]);

        $roles= roles_personal::find($id);
        $roles->cod_rol_per=$request->input('cod_rol_per');
        $roles->nombre_rol_per=$request->input('nombre_rol_per');
        $roles->save();

        return redirect()
            ->route('roles_personal.index')
            ->with('success', 'Rol creado correctamente.');
    }

   
    public function destroy($id) { $rol = roles_personal::find($id);
    
        if ($rol) {
            $rol->estado = $rol->estado? 0 : 1;
            $rol->save();
        }
        
       return redirect('roles_personal')->with('success', 'Estado del rol actualizado.');
}}
