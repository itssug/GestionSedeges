<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\roles;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('rol')->get();
        return view('admin.user.index', compact('user'));
    }

    public function pdf()
    {

        $usuarios = user::all();
        $pdf = Pdf::loadView('admin.usuarios.pdf', \compact('usuarios'));
        return $pdf->stream();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {

        $user = User::with('rol')->get();
        $roles = Roles::all();
        return view('admin.user.create', compact('user','roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    // Validación
    $request->validate([
        'cod_usu'        => 'required|string|max:50|unique:users,cod_usu',
        'name'           => 'required|string|max:100',
        'apellidos'      => 'required|string|max:100',
        'identificacion' => 'required|string|max:50|unique:users,identificacion',
        'fecha_nac'      => 'required|date',
        'contacto'       => 'required|string|max:20',
        'direccion'      => 'required|string|max:255',
        'email'          => 'required|email|unique:users,email',
        'password'       => 'required|string|min:6',
        'rol_id'         => 'required|exists:roles,id',
        'estado_usu'     => 'required|boolean',
    ]);

    // Crear usuario
    $usuario = new User();
    $usuario->cod_usu        = $request->cod_usu;
    $usuario->name           = $request->name;
    $usuario->apellidos      = $request->apellidos;
    $usuario->identificacion = $request->identificacion;
    $usuario->fecha_nac      = $request->fecha_nac;
    $usuario->contacto       = $request->contacto;
    $usuario->direccion      = $request->direccion;
    $usuario->email          = $request->email;
    $usuario->password       = Hash::make($request->password); // Nunca guardes contraseñas sin hash
    $usuario->rol_id         = $request->rol_id;
    $usuario->estado_usu     = $request->estado_usu;
    $usuario->save();

    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');


    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Roles::all();

        return view('admin.user.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los campos
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:70',
            'cod_usu' => 'required|string|max:20',
            'contacto' => 'required|string|max:20',
            'direccion' => 'required|string|max:70',
            'estado_usu' => 'required|boolean',
            'fecha_nac' => 'required|date',
            'identificacion' => 'required|string|max:30',
            'rol_id' => 'required|integer|exists:roles,id',
            'email' => 'required|email|max:255',
            // Si deseas actualizar contraseña, agrégala aquí
        ]);

        // Obtener el usuario
        $user = User::findOrFail($id);

        // Actualizar los campos
        $user->name = $request->name;
        $user->apellidos = $request->apellidos;
        $user->cod_usu = $request->cod_usu;
        $user->contacto = $request->contacto;
        $user->direccion = $request->direccion;
        $user->estado_usu = $request->estado_usu;
        $user->fecha_nac = $request->fecha_nac;
        $user->identificacion = $request->identificacion;
        $user->rol_id = $request->rol_id;
        $user->email = $request->email;

        // Si hay una nueva contraseña
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
