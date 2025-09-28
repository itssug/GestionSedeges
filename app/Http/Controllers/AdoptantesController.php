<?php

namespace App\Http\Controllers;

use App\Models\adoptantes;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdoptantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //obtener datos de usuarios y adoptantes
    //     $adoptantes = adoptantes::with('user')->get();
    //     return view('admin.adoptantes.index', compact('adoptantes'));
    // }

    public function pdf()
    {

        $adoptantes = adoptantes::all();
        $pdf = Pdf::loadView('admin.adoptantes.pdf', \compact('adoptantes'));
        return $pdf->stream();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('admin.adoptantes.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validación de todos los campos
    $request->validate([
        'name' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'fecha_nac' => 'required|date',
        'identificacion' => 'required|string|max:50|unique:users,identificacion',
        'contacto' => 'nullable|string|max:100',
        'direccion' => 'nullable|string|max:255',
        'ruta_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'pais' => 'required|string|max:100',
        'nacionalidad' => 'required|string|max:100',
        'estado_civil' => 'required|string|max:50',
        'nivel_educativo' => 'required|string|max:100',
        'ocupacion' => 'required|string|max:100',
        'ingresos_mensuales' => 'required|numeric|min:0',
        'email' => 'required|email',
    ]);

    // Generar código de usuario (por ejemplo: ADOP001)
    $ultimoUsuario = \App\Models\User::orderBy('id', 'desc')->first();
    $nuevoCodigo = 'ADOP' . str_pad(($ultimoUsuario->id + 1 ?? 1), 3, '0', STR_PAD_LEFT);

    // Guardar la imagen si se envió
    $rutaFoto = null;
    if ($request->hasFile('ruta_foto')) {
        $rutaFoto = $request->file('ruta_foto')->store('fotos_adoptantes', 'public');
    }

    // Crear usuario
    $usuario = \App\Models\User::create([
        'name' => $request->name,
        'apellidos' => $request->apellidos,
        'ruta_foto' => $rutaFoto,
        'cod_usu' => $nuevoCodigo,
        'ruta_foto' => $rutaFoto,
        'contacto' => $request->contacto,
        'direccion' => $request->direccion,
        'estado_usu' => 1,
        'fecha_nac' => $request->fecha_nac,
        'identificacion' => $request->identificacion,
        'rol_id' => 2, // Rol Adoptante
        'email' => $request->email,
        'email_verified_at' => now(), // Verificar el email automáticamente
        'password' => bcrypt('password123'), // Puedes generar aleatoria o pedir al usuario
    ]);

    // Crear adoptante asociado al usuario
    \App\Models\Adoptantes::create([

        'pais' => $request->pais,
        'nacionalidad' => $request->nacionalidad,
        'estado_civil' => $request->estado_civil,
        'nivel_educativo' => $request->nivel_educativo,
        'ocupacion' => $request->ocupacion,
        'ingresos_mensuales' => $request->ingresos_mensuales,
        'user_id' => $usuario->id,
    ]);

    return redirect()->route('adoptantes.index')->with('success', 'Adoptante registrado correctamente.');
}



    /**
     * Display the specified resource.
     */
    public function show(adoptantes $adoptantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(adoptantes $adoptante)
    {
        $usuarios = User::all();
        return view('admin.adoptantes.edit', compact('adoptante', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $adoptante = \App\Models\Adoptantes::findOrFail($id);
    $usuario = $adoptante->user;

    // Validación
    $request->validate([
        'name' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'fecha_nac' => 'required|date',
        'identificacion' => 'required|string|max:50|unique:users,identificacion,' . $usuario->id,
        'contacto' => 'nullable|string|max:100',
        'direccion' => 'nullable|string|max:255',
        'ruta_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'pais' => 'required|string|max:100',
        'nacionalidad' => 'required|string|max:100',
        'estado_civil' => 'required|string|max:50',
        'nivel_educativo' => 'required|string|max:100',
        'ocupacion' => 'required|string|max:100',
        'ingresos_mensuales' => 'required|numeric|min:0',
        'email' => 'required|email|unique:users,email,' . $usuario->id,
    ]);

    // Actualizar imagen si se envió una nueva
    if ($request->hasFile('ruta_foto')) {
        $rutaFoto = $request->file('ruta_foto')->store('fotos_adoptantes', 'public');
        $usuario->ruta_foto = $rutaFoto;
    }

    // Actualizar datos del usuario
    $usuario->update([
        'name' => $request->name,
        'apellidos' => $request->apellidos,
        'contacto' => $request->contacto,
        'direccion' => $request->direccion,
        'fecha_nac' => $request->fecha_nac,
        'identificacion' => $request->identificacion,
        'email' => $request->email,
    ]);

    // Actualizar datos del adoptante
    $adoptante->update([
        'pais' => $request->pais,
        'nacionalidad' => $request->nacionalidad,
        'estado_civil' => $request->estado_civil,
        'nivel_educativo' => $request->nivel_educativo,
        'ocupacion' => $request->ocupacion,
        'ingresos_mensuales' => $request->ingresos_mensuales,
    ]);

    return redirect()->route('adoptantes.index')->with('success', 'Adoptante actualizado correctamente.');
}



    /**
     * Remove the specified resource from storage.
     */
//    public function destroy($id)
// {

//     $adoptante = Adoptantes::findOrFail($id);
//     $user = User::findOrFail($adoptante->user_id);
//     $user->estado_usu = $user->estado_usu == 1 ? 0 : 1;
//     $user->save();

//     $mensaje = $user->estado_usu == 1 ? 'Adoptante desactivado correctamente.' : 'Adoptante activado correctamente.';

//     return redirect()->route('adoptantes.index')->with('success', $mensaje);
// }

public function destroy($id)
{
    try {
        $adoptante = adoptantes::with('user')->findOrFail($id);
        $user = $adoptante->user;

        // Alternar estado
        $nuevoEstado = $user->estado_usu == 1 ? 0 : 1;
        $user->estado_usu = $nuevoEstado;
        $user->save();

        $mensaje = $nuevoEstado == 1
            ? 'Adoptante activado correctamente.'
            : 'Adoptante desactivado correctamente.';

        return redirect()->route('adoptantes.index')->with('success', $mensaje);
    } catch (\Exception $e) {
        return redirect()->route('adoptantes.index')->with('error', 'Ocurrió un error al cambiar el estado del adoptante.');
    }
}



   public function adoptantesActivos()
{
    $adoptantes = Adoptantes::whereHas('user', function ($query) {
        $query->where('estado_usu', 1);
    })->get();

    $pdf = Pdf::loadView('admin.adoptantes.reportes_activos', compact('adoptantes'))
        ->setPaper('A4', 'landscape');

    return $pdf->stream('adoptantes_activos.pdf');
}


    //REPORTE NNAS INACTIVOS
   public function adoptantesInactivos()
{
    $adoptantes = Adoptantes::whereHas('user', function ($query) {
        $query->where('estado_usu', 0);
    })->get();

    $pdf = Pdf::loadView('admin.adoptantes.reportes_inactivos', compact('adoptantes'))
        ->setPaper('A4', 'landscape');

    return $pdf->stream('adoptantes_inactivos.pdf');
}

    public function index(Request $request)
{
    $query = Adoptantes::with('user'); // Solo adoptantes



    // Filtros por datos del usuario
    if ($request->filled('nombre')) {
        $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->nombre . '%'));
    }

    if ($request->filled('apellidos')) {
        $query->whereHas('user', fn($q) => $q->where('apellidos', 'like', '%' . $request->apellidos . '%'));
    }

    if ($request->filled('identificacion')) {
        $query->whereHas('user', fn($q) => $q->where('identificacion', 'like', '%' . $request->identificacion . '%'));
    }

    if ($request->filled('estado_usu') && in_array($request->estado_usu, [0,1])) {
        $query->whereHas('user', fn($q) => $q->where('estado_usu', $request->estado_usu));
    }

    if ($request->filled('fecha_nac_desde')) {
        $query->whereHas('user', fn($q) => $q->whereDate('fecha_nac', '>=', $request->fecha_nac_desde));
    }

    if ($request->filled('fecha_nac_hasta')) {
        $query->whereHas('user', fn($q) => $q->whereDate('fecha_nac', '<=', $request->fecha_nac_hasta));
    }

    // Filtros por datos del adoptante
    if ($request->filled('estado_civil')) {
        $query->where('estado_civil', $request->estado_civil);
    }

    if ($request->filled('nivel_educativo')) {
        $query->where('nivel_educativo', 'like', '%' . $request->nivel_educativo . '%');
    }

    if ($request->filled('ocupacion')) {
        $query->where('ocupacion', 'like', '%' . $request->ocupacion . '%');
    }

    if ($request->filled('pais')) {
        $query->where('pais', 'like', '%' . $request->pais . '%');
    }

    if ($request->filled('nacionalidad')) {
        $query->where('nacionalidad', 'like', '%' . $request->nacionalidad . '%');
    }

    if ($request->filled('ingresos_min')) {
        $query->where('ingresos_mensuales', '>=', $request->ingresos_min);
    }

    if ($request->filled('ingresos_max')) {
        $query->where('ingresos_mensuales', '<=', $request->ingresos_max);
    }

    $adoptantes = $query->orderByDesc('id')->paginate(10);

    return view('admin.adoptantes.index', compact('adoptantes'));
}







public function filtrarPDF(Request $request)
{
    $query = Adoptantes::with('user');

    // Aplica los mismos filtros que en index
    if ($request->filled('nombre')) {
        $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->nombre . '%'));
    }

    if ($request->filled('apellidos')) {
        $query->whereHas('user', fn($q) => $q->where('apellidos', 'like', '%' . $request->apellidos . '%'));
    }

    if ($request->filled('identificacion')) {
        $query->whereHas('user', fn($q) => $q->where('identificacion', 'like', '%' . $request->identificacion . '%'));
    }

    if ($request->filled('estado_usu') && in_array($request->estado_usu, [0,1])) {
        $query->whereHas('user', fn($q) => $q->where('estado_usu', $request->estado_usu));
    }

    if ($request->filled('fecha_nac_desde')) {
        $query->whereHas('user', fn($q) => $q->whereDate('fecha_nac', '>=', $request->fecha_nac_desde));
    }

    if ($request->filled('fecha_nac_hasta')) {
        $query->whereHas('user', fn($q) => $q->whereDate('fecha_nac', '<=', $request->fecha_nac_hasta));
    }

    if ($request->filled('estado_civil')) {
        $query->where('estado_civil', $request->estado_civil);
    }

    if ($request->filled('nivel_educativo')) {
        $query->where('nivel_educativo', 'like', '%' . $request->nivel_educativo . '%');
    }

    if ($request->filled('ocupacion')) {
        $query->where('ocupacion', 'like', '%' . $request->ocupacion . '%');
    }

    if ($request->filled('pais')) {
        $query->where('pais', 'like', '%' . $request->pais . '%');
    }

    if ($request->filled('nacionalidad')) {
        $query->where('nacionalidad', 'like', '%' . $request->nacionalidad . '%');
    }

    if ($request->filled('ingresos_min')) {
        $query->where('ingresos_mensuales', '>=', $request->ingresos_min);
    }

    if ($request->filled('ingresos_max')) {
        $query->where('ingresos_mensuales', '<=', $request->ingresos_max);
    }

    $adoptantes = $query->orderByDesc('id')->get(); // Sin paginar, para el PDF

    $date = date('d/m/Y');

   $pdf = Pdf::loadView('admin.adoptantes.pdf', compact('adoptantes'));
    return $pdf->stream('adoptantes.pdf'); // o ->download('archivo.pdf')
}




}
