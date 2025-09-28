<?php

namespace App\Http\Controllers;

use App\Models\personalSedeges;
use App\Models\roles_personal;
use App\Models\User;
use Illuminate\Http\Request;

class PersonalSedegesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Filtros desde la vista
    $nombre = $request->input('nombre');
    $apellidos = $request->input('apellidos');
    $especialidad = $request->input('especialidad');
    $area = $request->input('area');
    $rol_id = $request->input('rol_id');
    $estado = $request->input('estado');

    // Consulta base con relaciones necesarias
    $query = PersonalSedeges::with(['usuario', 'rolesPersonal']);

    // Aplicar filtros condicionalmente
    if ($nombre) {
        $query->whereHas('usuario', function ($q) use ($nombre) {
            $q->where('name', 'like', '%' . $nombre . '%');
        });
    }

    if ($apellidos) {
        $query->whereHas('usuario', function ($q) use ($apellidos) {
            $q->where('apellidos', 'like', '%' . $apellidos . '%');
        });
    }

    if ($especialidad) {
        $query->where('especialidad', 'like', '%' . $especialidad . '%');
    }

    if ($area) {
        $query->where('area', 'like', '%' . $area . '%');
    }

    if ($rol_id) {
        $query->where('roles_personal_id', $rol_id);
    }

    if ($estado !== null) {
        $query->where('estado', $estado);
    }

    // Obtener todos los resultados filtrados
    $personal = $query->get();

    // Obtener roles para el filtro select
    $roles = Roles_Personal::all();

    return view('admin.personal.index', compact('personal', 'roles'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all(); // O los filtrados según tu lógica
        $roles_personal = roles_personal::all();

        return view('admin.personal.create', compact('usuarios', 'roles_personal'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    //dd($request->all());
    // Validación
    $request->validate([
        'user_id' => 'required|exists:users,id',  // Asegúrate de usar el nombre correcto
        'especialidad' => 'required|string',
        'area' => 'required|string',
        'fecha_ingreso' => 'required|date',
        'horario_laboral' => 'required|string',
        'roles_personal_id' => 'required|exists:roles_personals,id',
        'estado' => 'required|boolean',
        'foto' => 'nullable|image|max:2048',
    ]);

    // Manejo de la foto (si es que hay)
    $foto = null;
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto')->store('fotos_personal', 'public');
    }

    // Crear el nuevo personal
    PersonalSedeges::create([
        'user_id' => $request->user_id,  // Aquí cambiamos a 'user_id'
        'especialidad' => $request->especialidad,
        'area' => $request->area,
        'fecha_ingreso' => $request->fecha_ingreso,
        'horario_laboral' => $request->horario_laboral,
        'roles_personal_id' => $request->roles_personal_id,
        'estado' => $request->estado,
        'foto' => $foto,
    ]);

    return redirect()->route('personal.index')->with('success', 'Personal registrado con éxito.');
}


    /**
     * Display the specified resource.
     */
    public function show(personalSedeges $personalSedeges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    // Buscar el personal por id con su relación usuario y rol
    $personal = personalSedeges::with(['usuario', 'rolesPersonal'])->findOrFail($id);

    // Obtener todos los roles para el select en la vista
    $roles = roles_Personal::all();

    // Retornar la vista de edición pasando el personal y los roles
    return view('admin.personal.edit', compact('personal', 'roles'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validar los datos recibidos
    $request->validate([
        'foto' => 'nullable|image|max:2048', // max 2MB
        'name' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'especialidad' => 'required|string|max:255',
        'area' => 'required|string|max:255',
        'fecha_ingreso' => 'required|date|before_or_equal:today',
        'anios_antiguedad' => 'nullable|integer|min:0',
        'horario_laboral' => 'nullable|string|max:255',
        'roles_personal_id' => 'required|exists:roles_personal,id',
        'estado' => 'required|boolean',
        'password' => 'nullable|string|min:6|confirmed', // opcional con confirmación
    ]);

    // Buscar el personal y usuario relacionado
    $personal = personalSedeges::findOrFail($id);
    $usuario = $personal->usuario;

    // Actualizar datos del usuario
    $usuario->name = $request->input('name');
    $usuario->apellidos = $request->input('apellidos');
    // No actualizamos email porque está readonly

    if ($request->filled('password')) {
        $usuario->password = bcrypt($request->input('password'));
    }

    // Manejo de la foto
    if ($request->hasFile('foto')) {
        // Borrar la foto anterior si existe
        if ($usuario->foto && \Storage::exists($usuario->foto)) {
            \Storage::delete($usuario->foto);
        }
        // Guardar la nueva foto
        $ruta = $request->file('foto')->store('personal_fotos', 'public');
        $usuario->foto = $ruta;
    }

    $usuario->save();

    // Actualizar datos del personal
    $personal->especialidad = $request->input('especialidad');
    $personal->area = $request->input('area');
    $personal->fecha_ingreso = $request->input('fecha_ingreso');
    $personal->anios_antiguedad = $request->input('anios_antiguedad');
    $personal->horario_laboral = $request->input('horario_laboral');
    $personal->roles_personal_id = $request->input('roles_personal_id');
    $personal->estado = $request->input('estado');

    $personal->save();

    return redirect()->route('personal.index')
        ->with('success', 'Personal actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Buscar el personal y su usuario relacionado
    $personal = personalSedeges::findOrFail($id);
    $usuario = $personal->usuario;

    // Verificar si existe usuario relacionado
    if ($usuario) {
        // Intercalar estado entre 1 y 0
        $usuario->estado_usu = $usuario->estado_usu == 1 ? 0 : 1;
        $usuario->save();
    }

    return redirect()->route('personal.index')->with('success', 'Estado actualizado correctamente.');
}
}
