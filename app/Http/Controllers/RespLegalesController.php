<?php

namespace App\Http\Controllers;

use App\Models\RespLegales;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\TipoRespLegales;



class RespLegalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $resp_legales = RespLegales::with(['user'])->get();
    //     return view('admin.resp_legales.index', compact('resp_legales'));
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();

        return view('admin.resp_legales.create', compact('usuarios',));
    }


    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nac' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d'),
            'identificacion' => 'required|string|max:20|unique:users,identificacion',
            'contacto' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'ruta_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'direccion_oficina' => 'nullable|string|max:255',
            'especialidad' => 'required|string|max:255',
            'horarios_atencion' => 'required|string|max:255',
        ]);

        // Generar cod_usu (ej: RESP001, RESP002, etc.)
        $lastUser = User::where('rol_id', 4)->orderBy('id', 'desc')->first();
        $nextNumber = $lastUser ? (int)Str::after($lastUser->cod_usu, 'RESP') + 1 : 1;
        $cod_usu = 'RESP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);


        // Subir imagen si existe
        $rutaFoto = null;
        if ($request->hasFile('ruta_foto')) {
            $extension = $request->file('ruta_foto')->getClientOriginalExtension(); // ej: jpg, png
            $fileName = $cod_usu . '.' . $extension; // RESP001.jpg
            $rutaFoto = $request->file('ruta_foto')->storeAs('resp_legales', $fileName, 'public');
        }


        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'cod_usu' => $cod_usu,
            'ruta_foto' => $rutaFoto,
            'contacto' => $request->contacto,
            'direccion' => null,
            'estado_usu' => 1,
            'fecha_nac' => $request->fecha_nac,
            'identificacion' => $request->identificacion,
            'rol_id' => 4,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Crear responsable legal asociado
        RespLegales::create([
            'direccion_oficina' => $request->direccion_oficina,
            'especialidad' => $request->especialidad,
            'horarios_atencion' => $request->horarios_atencion,
            'user_id' => $user->id
        ]);

        return redirect()->route('resp_legales.index')->with('success', 'Responsable legal creado correctamente.');
    }



    /**
     * Display the specified resource.
     */
    public function show(RespLegales $respLegales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $responsable = RespLegales::with('user')->findOrFail($id);
        return view('admin.resp_legales.edit', compact('responsable'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $resp = RespLegales::with('user')->findOrFail($id);
        $user = $resp->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nac' => 'required|date|before:' . now()->subYears(10)->format('Y-m-d'),
            'identificacion' => 'required|string|max:20|unique:users,identificacion,' . $user->id,
            'contacto' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'ruta_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'direccion_oficina' => 'nullable|string|max:255',
            'especialidad' => 'required|string|max:255',
            'horarios_atencion' => 'required|string|max:255',
        ]);

        // Subir nueva foto si se proporciona
        if ($request->hasFile('ruta_foto')) {
            $extension = $request->file('ruta_foto')->getClientOriginalExtension();
            $fileName = $user->cod_usu . '.' . $extension;
            $rutaFoto = $request->file('ruta_foto')->storeAs('resp_legales', $fileName, 'public');
            $user->ruta_foto = $rutaFoto;
        }

        // Actualizar datos del usuario
        $user->update([
            'name' => $request->name,
            'apellidos' => $request->apellidos,
            'fecha_nac' => $request->fecha_nac,
            'identificacion' => $request->identificacion,
            'contacto' => $request->contacto,
            'email' => $request->email,
        ]);

        // Actualizar datos del responsable legal
        $resp->update([
            'direccion_oficina' => $request->direccion_oficina,
            'especialidad' => $request->especialidad,
            'horarios_atencion' => $request->horarios_atencion,
        ]);

        return redirect()->route('resp_legales.index')->with('success', 'Responsable legal actualizado correctamente.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $responsable = RespLegales::with('user')->findOrFail($id);
        $user = $responsable->user;

        // Alternar estado
        $nuevoEstado = $user->estado_usu == 1 ? 0 : 1;
        $user->estado_usu = $nuevoEstado;
        $user->save();

        $mensaje = $nuevoEstado == 1
            ? 'Responsable Legal activado correctamente.'
            : 'Responsable Legal desactivado correctamente.';

        return redirect()->route('resp_legales.index')->with('success', $mensaje);
    }


    //REPORTES CON FILTROS
    //envio al index con reportes

 public function index(Request $request)
{
    $query = RespLegales::with('user');

    if ($request->filled('name')) {
        $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->name . '%'));
    }

    if ($request->filled('estado_usu') && in_array($request->estado_usu, [0,1])) {
        $query->whereHas('user', fn($q) => $q->where('estado_usu', $request->estado_usu));
    }

    if ($request->filled('apellidos')) {
        $query->whereHas('user', fn($q) => $q->where('apellidos', 'like', '%' . $request->apellidos . '%'));
    }

    if ($request->filled('fecha_nac')) {
        $query->whereHas('user', fn($q) => $q->whereDate('fecha_nac', $request->fecha_nac));
    }

    if ($request->filled('identificacion')) {
        $query->whereHas('user', fn($q) => $q->where('identificacion', 'like', '%' . $request->identificacion . '%'));
    }

    if ($request->filled('contacto')) {
        $query->whereHas('user', fn($q) => $q->where('contacto', 'like', '%' . $request->contacto . '%'));
    }

    if ($request->filled('email')) {
        $query->whereHas('user', fn($q) => $q->where('email', 'like', '%' . $request->email . '%'));
    }

    // Filtros en RespLegales directamente
    if ($request->filled('especialidad')) {
        $query->where('especialidad', 'like', '%' . $request->especialidad . '%');
    }

    if ($request->filled('direccion_oficina')) {
        $query->where('direccion_oficina', 'like', '%' . $request->direccion_oficina . '%');
    }

    if ($request->filled('horarios_atencion')) {
        $query->where('horarios_atencion', 'like', '%' . $request->horarios_atencion . '%');
    }

    $resp_legales = $query->paginate(10)->appends($request->all());

    return view('admin.resp_legales.index', compact('resp_legales'));
}


public function filtrarPDF(Request $request)
{
    $query = RespLegales::with('user');

    if ($request->filled('name')) {
        $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->name . '%'));
    }

    if ($request->filled('estado_usu') && in_array($request->estado_usu, [0,1])) {
        $query->whereHas('user', fn($q) => $q->where('estado_usu', $request->estado_usu));
    }

    if ($request->filled('apellidos')) {
        $query->whereHas('user', fn($q) => $q->where('apellidos', 'like', '%' . $request->apellidos . '%'));
    }

    if ($request->filled('fecha_nac')) {
        $query->whereHas('user', fn($q) => $q->whereDate('fecha_nac', $request->fecha_nac));
    }

    if ($request->filled('identificacion')) {
        $query->whereHas('user', fn($q) => $q->where('identificacion', 'like', '%' . $request->identificacion . '%'));
    }

    if ($request->filled('contacto')) {
        $query->whereHas('user', fn($q) => $q->where('contacto', 'like', '%' . $request->contacto . '%'));
    }

    if ($request->filled('email')) {
        $query->whereHas('user', fn($q) => $q->where('email', 'like', '%' . $request->email . '%'));
    }

    if ($request->filled('especialidad')) {
        $query->where('especialidad', 'like', '%' . $request->especialidad . '%');
    }

    if ($request->filled('direccion_oficina')) {
        $query->where('direccion_oficina', 'like', '%' . $request->direccion_oficina . '%');
    }

    if ($request->filled('horarios_atencion')) {
        $query->where('horarios_atencion', 'like', '%' . $request->horarios_atencion . '%');
    }

    $usuarios = $query->get();

    $pdf = Pdf::loadView('admin.resp_legales.pdf', compact('usuarios'));
    return $pdf->stream('resp_legales.pdf');
}


}
