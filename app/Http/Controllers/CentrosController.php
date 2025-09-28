<?php

namespace App\Http\Controllers;

use App\Models\centros;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




class CentrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centros = centros::all();
        return view('admin.centros.index', ['centros' => $centros]);
    }

    public function pdf()
    {

        $centros = centros::all();
        $pdf = Pdf::loadView('admin.centros.pdf', \compact('centros'));
        return $pdf->stream();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.centros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try { // Validar los datos
            $request->validate([
                'cod_centro'      => 'required|string|max:50|unique:centros,cod_centro',
                'nombre_centro'   => 'required|string|max:100',
                'direccion_centro' => 'required|string|max:255',
                'contacto'        => 'required|string|max:100',
                'capacidad'       => 'required|integer|min:0',
            ]);

            // 2) Creación del modelo y asignación de campos
            $centro = new centros();
            $centro->cod_centro       = $request->input('cod_centro');
            $centro->nombre_centro    = $request->input('nombre_centro');
            $centro->direccion_centro = $request->input('direccion_centro');
            $centro->contacto         = $request->input('contacto');
            $centro->capacidad        = $request->input('capacidad');
            $centro->estado           = 1;

            // 3) Guardar en la base
            $centro->save();

            return redirect()->route('centros.index')->with('success', 'Centro creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('centros.index')->with('error', 'centro no creado.' . ' ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(centros $centros)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $centros = centros::find($id);

        return view('admin.centros.edit', ['centros' => $centros]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1) Validar los datos
        $request->validate([
            'cod_centro'       => 'required|string|max:50|unique:centros,cod_centro,' . $id,
            'nombre_centro'    => 'required|string|max:100',
            'direccion_centro' => 'nullable|string|max:255',
            'contacto'         => 'nullable|string|max:100',
            'capacidad'        => 'nullable|integer|min:0',

        ]);

        // 2) Recuperar el modelo
        $centro = centros::findOrFail($id);

        // 3) Asignar los nuevos valores
        $centro->cod_centro       = $request->cod_centro;
        $centro->nombre_centro    = $request->nombre_centro;
        $centro->direccion_centro = $request->direccion_centro;
        $centro->contacto         = $request->contacto;
        $centro->capacidad        = $request->capacidad;
        $centro->estado           = 1;



        // 4) Guardar cambios
        $centro->save();

        // 5) Redireccionar con mensaje
        return redirect()
            ->route('centros.index')
            ->with('success', 'Centro actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $centros = centros::find($id);

        if ($centros) {

            $centros->estado = $centros->estado ? 0 : 1;
            $centros->save();
        }

        return redirect('centros')->with('success', 'Estado del centro actualizado.');
    }

    public function centroActivos()
    {
        $centros = centros::where('estado', 1)->get();

        $pdf = Pdf::loadView('admin.centros.reportes_activos', compact('centros'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('centros_activos.pdf');
    }

    //REPORTE NNAS INACTIVOS
    public function centroInactivos()
    {
        $centros = centros::where('estado', 0)->get();
        $pdf = Pdf::loadView('admin.centros.reportes_inactivos', compact('centros'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('centros_inactivos.pdf');
    }

    public function filtrar(Request $request)
    {
        $query = centros::query();

        // Campos exactos (igual que en Nnas)
        $camposExactos = [
            'cod_centro',
            'nombre_centro',
            'direccion_centro',
            'contacto',
            'capacidad',
            'estado'
        ];

        foreach ($camposExactos as $campo) {
            if ($request->filled($campo)) {
                if (in_array($campo, ['capacidad', 'estado'])) {
                    // Para capacidad y estado, exacto
                    $query->where($campo, $request->$campo);
                } else {
                    // Para texto, usamos LIKE
                    $query->where($campo, 'like', '%' . $request->$campo . '%');
                }
            }
        }

        // Rangos para capacidad (ejemplo)
        if ($request->filled('capacidad_min')) {
            $query->where('capacidad', '>=', $request->capacidad_min);
        }
        if ($request->filled('capacidad_max')) {
            $query->where('capacidad', '<=', $request->capacidad_max);
        }

        $centros = $query->get();

        return view('admin.centros.index', compact('centros'));
    }

    public function filtrarPdf(Request $request)
    {
        $query = centros::query();

        $camposExactos = [
            'cod_centro',
            'nombre_centro',
            'direccion_centro',
            'contacto',
            'capacidad',
            'estado'
        ];

        foreach ($camposExactos as $campo) {
            if ($request->filled($campo)) {
                if (in_array($campo, ['capacidad', 'estado'])) {
                    $query->where($campo, $request->$campo);
                } else {
                    $query->where($campo, 'like', '%' . $request->$campo . '%');
                }
            }
        }

        if ($request->filled('capacidad_min')) {
            $query->where('capacidad', '>=', $request->capacidad_min);
        }
        if ($request->filled('capacidad_max')) {
            $query->where('capacidad', '<=', $request->capacidad_max);
        }

        $centros = $query->get();

        // Armar filtros para mostrar en PDF
        $filters = [];
        foreach ($request->all() as $key => $value) {
            if (!empty($value)) {
                $filters[$key] = $value;
            }
        }

        $pdf = Pdf::loadView('admin.centros.pdf', compact('centros', 'filters'));

        return $pdf->download('reporte_centros_filtrados.pdf');
    }

public function reporte1(Request $request)
    {
        $centroId = $request->centro_id;

        // Consulta SQL para obtener información del centro
        $centroSql = "
            SELECT
                cod_centro,
                nombre_centro,
                direccion_centro,
                contacto
            FROM
                centros
            WHERE
                id = ?
        ";

        // Consulta SQL para obtener NNAs del centro
        $nnasSql = "
            SELECT
                nombres,
                apellidos,
                sexo,
                cod_nna,
                fecha_nac
            FROM
                nnas
            WHERE
                centro_id = ?
            ORDER BY
                apellidos, nombres
        ";

        // Ejecutar consultas
        $centro = collect(DB::select($centroSql, [$centroId]))->first();
        $nnas = collect(DB::select($nnasSql, [$centroId]));
        $totalNnas = count($nnas);

        // Generar PDF
        $pdf = PDF::loadView('admin.centros.pdf_reporte1', compact('centro', 'nnas', 'totalNnas'));

        // Nombre del archivo PDF
        $filename = 'centro_'.$centro->cod_centro.'.pdf';

        // Mostrar en el navegador
        return $pdf->stream($filename);

        // O para descargar directamente:
        // return $pdf->download($filename);
    }

}
