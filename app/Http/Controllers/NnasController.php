<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\centros;
use App\Models\nnas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class NnasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nnas = nnas::with('centro')->get();
        $centros = centros::all();
        return view('admin.nnas.index', compact('nnas', 'centros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $centros = centros::all(); // Obtener todos los centros
        return view('admin.nnas.create', compact('centros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cod_nna' => 'required|string|max:255|unique:nnas,cod_nna',
            'tipo_identificacion' => 'required|string',
            'identificacion' => 'nullable|string|max:255',
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nac' => 'nullable|date|before_or_equal:today',
            'sexo' => 'required|string',
            'nacionalidad' => 'nullable|string|max:255',
            'situacion_juridica' => 'nullable|string|max:255',
            'nivel_educativo' => 'nullable|string|max:255',
            'ruta_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'motivo_ingreso' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'fecha_ingreso' => 'nullable|date|before_or_equal:today',
            'fecha_salida' => 'nullable|date|after:fecha_ingreso',
            'discapacidad' => 'required|in:0,1',
            'tipo_discapacidad' => 'nullable|string|required_if:discapacidad,1',
            'centro_id' => 'required|exists:centros,id',
        ]);

        if ($request->hasFile('ruta_foto')) {
            $archivo = $request->file('ruta_foto');

            if ($archivo->isValid()) {
                $cod_nna = $request->input('cod_nna');
                $nombreOriginal = str_replace(' ', '_', $archivo->getClientOriginalName());
                $nombreArchivo = $cod_nna . '_' . time() . '_' . $nombreOriginal;
                $rutaFoto = $archivo->storeAs('fotos_nna', $nombreArchivo, 'public');
                $validatedData['ruta_foto'] = $rutaFoto;
            }
        }

        $validatedData['estado'] = 1;

        // Crear NNA y obtener la instancia
        $nna = Nnas::create($validatedData);

        // Si tiene discapacidad, redirigir al formulario de registro de documento
        if ($request->discapacidad == 1) {
            return redirect()->route('documentosNnas.create', ['nna_id' => $nna->id])
                ->with('info', 'NNA registrado correctamente. Por favor, suba el comprobante de discapacidad.');
        }

        // Si no tiene discapacidad, redirigir normalmente
        return redirect()->route('nnas.index')->with('success', 'NNA registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(nnas $nnas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nna = nnas::findOrFail($id);
        $centros = centros::all(); // Para el select de centros

        return view('admin.nnas.edit', compact('nna', 'centros'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validamos los datos del formulario
            $validatedData = $request->validate([
                'cod_nna' => 'required|string|max:255|unique:nnas,cod_nna,' . $id,
                'tipo_identificacion' => 'required|string',
                'identificacion' => 'nullable|string|max:255',
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'fecha_nac' => 'nullable|date',
                'sexo' => 'required|string',
                'nacionalidad' => 'nullable|string|max:255',
                'situacion_juridica' => 'nullable|string|max:255',
                'nivel_educativo' => 'nullable|string|max:255',
                'motivo_ingreso' => 'nullable|string',
                'fecha_ingreso' => 'nullable|date',
                'fecha_salida' => 'nullable|date|after_or_equal:fecha_ingreso',
                'observaciones' => 'nullable|string',
                'tipo_discapacidad' => 'nullable|string|required_if:discapacidad,1',
                'centro_id' => 'required|exists:centros,id',
                'ruta_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Si el usuario subió una nueva foto
            if ($request->hasFile('ruta_foto')) {
                // Guardamos la imagen en storage/app/public/fotos_nna
                $rutaFoto = $request->file('ruta_foto')->store('fotos_nna', 'public');
                $validatedData['ruta_foto'] = $rutaFoto;
            }

            // Buscamos el registro del NNA
            $nna = nnas::findOrFail($id);

            // Se establece el estado activo
            $validatedData['estado'] = 1;

            // Actualizamos con los datos validados
            $nna->update($validatedData);

            // Redirigimos con mensaje de éxito
            return redirect()->route('nnas.index')->with('success', 'NNA actualizado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, redirigimos de vuelta con el mensaje de error
            return redirect()->route('nnas.index')->with('error', 'Ocurrió un error al actualizar el NNA: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $nna = nnas::find($id);

        if ($nna) {
            // Alternar el estado entre 1 y 0
            $nna->estado = $nna->estado ? 0 : 1;
            $nna->save();
        }

        return redirect('nnas')->with('success', 'Estado del nna actualizado.');
    }

    public function reporteNna($id)
    {
        $resultado = DB::selectOne('
            SELECT
                nnas.ruta_foto, nnas.cod_nna, nnas.nombres, nnas.apellidos,
                nnas.tipo_identificacion, nnas.identificacion, nnas.fecha_nac,
                nnas.sexo, nnas.nacionalidad, nnas.situacion_juridica,
                nnas.fecha_ingreso, nnas.fecha_salida, nnas.nivel_educativo,
                nnas.motivo_ingreso, nnas.discapacidad, nnas.centro_id,
                centros.nombre_centro,

                ep.diagnostico AS diagnostico_psicologico,
                ep.observaciones AS observaciones_psicologicas,
                up.name AS evaluador_psicologico,

                em.fecha AS fecha_medica,
                em.diagnostico AS diagnostico_medico,
                em.observaciones AS observaciones_medicas,
                um.name AS evaluador_medico

            FROM nnas
            INNER JOIN centros ON centros.id = nnas.centro_id

            LEFT JOIN (
                SELECT p1.*
                FROM evaluaciones_psicologicas p1
                INNER JOIN (
                    SELECT nna_id, MAX(fecha) AS max_fecha
                    FROM evaluaciones_psicologicas
                    GROUP BY nna_id
                ) p2 ON p1.nna_id = p2.nna_id AND p1.fecha = p2.max_fecha
            ) ep ON ep.nna_id = nnas.id
            LEFT JOIN personal_sedeges eps ON eps.id = ep.personal_sedeges_id
            LEFT JOIN users up ON up.id = eps.user_id

            LEFT JOIN (
                SELECT m1.*
                FROM evaluaciones_medicas m1
                INNER JOIN (
                    SELECT nna_id, MAX(fecha) AS max_fecha
                    FROM evaluaciones_medicas
                    GROUP BY nna_id
                ) m2 ON m1.nna_id = m2.nna_id AND m1.fecha = m2.max_fecha
            ) em ON em.nna_id = nnas.id
            LEFT JOIN personal_sedeges ems ON ems.id = em.personal_sedeges_id
            LEFT JOIN users um ON um.id = ems.user_id

            WHERE nnas.id = ?
        ', [$id]);

        if (!$resultado) {
            abort(404, 'NNA no encontrado');
        }
    //dd(file_exists(public_path('fotos_nna/aUOkMs96IAQGmxNfhpoCm96NPk6YbGVxEczvZZbi.jpg')));

        //dd($resultado);

        $pdf = Pdf::loadView('admin.nnas.reportes_nna', compact('resultado'));
        return $pdf->stream("reporte_nna_{$resultado->cod_nna}.pdf");
    }


    //REPORTES COMPLETOS DE NNAS

    // public function reporteNna($id)
    // {
    //     $resultado = DB::selectOne('
    //     SELECT
    //         nnas.ruta_foto, nnas.cod_nna, nnas.nombres, nnas.apellidos,
    //         nnas.tipo_identificacion, nnas.identificacion, nnas.fecha_nac,
    //         nnas.sexo, nnas.nacionalidad, nnas.situacion_juridica,
    //         nnas.fecha_ingreso, nnas.fecha_salida, nnas.nivel_educativo,
    //         nnas.motivo_ingreso, nnas.discapacidad, nnas.centro_id,
    //         centros.nombre_centro,

    //         ep.diagnostico AS diagnostico_psicologico,
    //         ep.observaciones AS observaciones_psicologicas,
    //         up.name AS evaluador_psicologico,

    //         em.fecha AS fecha_medica,
    //         em.diagnostico AS diagnostico_medico,
    //         em.observaciones AS observaciones_medicas,
    //         um.name AS evaluador_medico

    //     FROM nnas
    //     INNER JOIN centros ON centros.id = nnas.centro_id

    //     LEFT JOIN (
    //         SELECT p1.*
    //         FROM evaluaciones_psicologicas p1
    //         INNER JOIN (
    //             SELECT nna_id, MAX(fecha) AS max_fecha
    //             FROM evaluaciones_psicologicas
    //             GROUP BY nna_id
    //         ) p2 ON p1.nna_id = p2.nna_id AND p1.fecha = p2.max_fecha
    //     ) ep ON ep.nna_id = nnas.id
    //     LEFT JOIN personal_sedeges eps ON eps.id = ep.personal_sedeges_id
    //     LEFT JOIN users up ON up.id = eps.user_id

    //     LEFT JOIN (
    //         SELECT m1.*
    //         FROM evaluaciones_medicas m1
    //         INNER JOIN (
    //             SELECT nna_id, MAX(fecha) AS max_fecha
    //             FROM evaluaciones_medicas
    //             GROUP BY nna_id
    //         ) m2 ON m1.nna_id = m2.nna_id AND m1.fecha = m2.max_fecha
    //     ) em ON em.nna_id = nnas.id
    //     LEFT JOIN personal_sedeges ems ON ems.id = em.personal_sedeges_id
    //     LEFT JOIN users um ON um.id = ems.user_id

    //     WHERE nnas.id = ?
    // ', [$id]);

    //     return view('admin.nnas.reportes_nna', compact('resultado'));
    // }

    //REPORTE DE NNAS ACTIVOS

    public function nnaActivos()
    {
        $nnas = Nnas::where('estado', 1)->get();

        $pdf = Pdf::loadView('admin.nnas.reportes_activos', compact('nnas'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('nna_activos.pdf');
    }

    //REPORTE NNAS INACTIVOS
    public function nnaInactivos()
    {
        $nnas = nnas::where('estado', 0)->get();
        $pdf = Pdf::loadView('admin.nnas.reportes_inactivos', compact('nnas'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('nna_inactivos.pdf');
    }

    public function filtrar(Request $request)
    {
        $centros = centros::all();
        $query = Nnas::query();

        $camposExactos = [
            'sexo',
            'tipo_identificacion',
            'situacion_juridica',
            'nivel_educativo',
            'nacionalidad',
            'discapacidad',
            'centro_id'
        ];
        foreach ($camposExactos as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, $request->$campo);
            }
        }

        $camposLike = ['cod_nna', 'identificacion', 'nombres', 'apellidos', 'motivo_ingreso', 'tipo_discapacidad'];
        foreach ($camposLike as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, 'like', '%' . $request->$campo . '%');
            }
        }

        if ($request->filled('fecha_nac_inicio')) {
            $query->where('fecha_nac', '>=', $request->fecha_nac_inicio);
        }
        if ($request->filled('fecha_nac_fin')) {
            $query->where('fecha_nac', '<=', $request->fecha_nac_fin);
        }
        if ($request->filled('fecha_ingreso_inicio')) {
            $query->where('fecha_ingreso', '>=', $request->fecha_ingreso_inicio);
        }
        if ($request->filled('fecha_ingreso_fin')) {
            $query->where('fecha_ingreso', '<=', $request->fecha_ingreso_fin);
        }
        if ($request->filled('fecha_salida')) {
            $query->whereDate('fecha_salida', $request->fecha_salida);
        }

        $nnas = $query->get();

        return view('admin.nnas.index', compact('nnas', 'centros'));
    }




public function filtrarPdf(Request $request)
{
    //dd($request->all()); // Para depurar y ver los datos del request
    $centros = Centros::all();  // si necesitas centros para algo

    $query = Nnas::query();

    $camposExactos = [
        'sexo',
        'tipo_identificacion',
        'situacion_juridica',
        'nivel_educativo',
        'nacionalidad',
        'discapacidad',
        'centro_id'
    ];
    foreach ($camposExactos as $campo) {
        if ($request->filled($campo)) {
            $query->where($campo, $request->$campo);
        }
    }

    $camposLike = ['cod_nna', 'identificacion', 'nombres', 'apellidos', 'motivo_ingreso', 'tipo_discapacidad'];
    foreach ($camposLike as $campo) {
        if ($request->filled($campo)) {
            $query->where($campo, 'like', '%' . $request->$campo . '%');
        }
    }

    if ($request->filled('fecha_nac_inicio')) {
        $query->where('fecha_nac', '>=', $request->fecha_nac_inicio);
    }
    if ($request->filled('fecha_nac_fin')) {
        $query->where('fecha_nac', '<=', $request->fecha_nac_fin);
    }
    if ($request->filled('fecha_ingreso_inicio')) {
        $query->where('fecha_ingreso', '>=', $request->fecha_ingreso_inicio);
    }
    if ($request->filled('fecha_ingreso_fin')) {
        $query->where('fecha_ingreso', '<=', $request->fecha_ingreso_fin);
    }
    if ($request->filled('fecha_salida')) {
        $query->whereDate('fecha_salida', $request->fecha_salida);
    }

    $nnas = $query->get();

    // Armar array con filtros para enviar a la vista y mostrar en PDF
    $filters = [];
    foreach ($request->all() as $key => $value) {
        if (!empty($value)) {
            // Si la fecha la parseamos bonito para mostrar
            if (str_contains($key, 'fecha')) {
                try {
                    $filters[$key] = Carbon::parse($value)->format('d/m/Y');
                } catch (\Exception $e) {
                    $filters[$key] = $value; // si no es fecha válida la mostramos tal cual
                }
            } else {
                $filters[$key] = $value;
            }
        }
    }

    $pdf = Pdf::loadView('admin.nnas.pdf', compact('nnas', 'filters'))->setPaper('A4', 'landscape');;

    return $pdf->stream('reporte_nnas_filtrados.pdf');
}

}
