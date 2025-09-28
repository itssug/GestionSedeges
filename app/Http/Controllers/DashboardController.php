<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // Adoptantes
        $adoptantesPorEstado = DB::table('adoptantes')
            ->join('users', 'adoptantes.user_id', '=', 'users.id')
            ->select('estado_usu', DB::raw('COUNT(*) as total'))
            ->groupBy('estado_usu')
            ->pluck('total', 'estado_usu');

        // NNA
        $nnaPorEdad = DB::table('nnas')
            ->select(DB::raw('TIMESTAMPDIFF(YEAR, fecha_nac, CURDATE()) as edad'), DB::raw('COUNT(*) as total'))
            ->groupBy('edad')
            ->orderBy('edad')
            ->pluck('total', 'edad');

        $nnaPorSexo = DB::table('nnas')
            ->select('sexo', DB::raw('COUNT(*) as total'))
            ->groupBy('sexo')
            ->pluck('total', 'sexo');

        $nnaPorEstado = DB::table('nnas')
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // Capacitaciones
        $participacionPorCapacitacion = DB::table('capacitaciones as c')
            ->join('sesiones as s', 'c.id', '=', 's.capacitacion_id')
            ->join('asistencias as a', 's.id', '=', 'a.sesion_id')
            ->select('c.nombre', DB::raw('COUNT(DISTINCT a.adoptante_id) as total'))
            ->groupBy('c.nombre')
            ->pluck('total', 'c.nombre');

        $asistenciasTotales = DB::table('capacitaciones as c')
            ->join('sesiones as s', 'c.id', '=', 's.capacitacion_id')
            ->join('asistencias as a', 's.id', '=', 'a.sesion_id')
            ->select('c.nombre', DB::raw('COUNT(*) as total'))
            ->groupBy('c.nombre')
            ->pluck('total', 'c.nombre');

        // Trámites
        $tramitesRaw = DB::table('tramites_adoptantes')
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // Traducir clave 0 y 1
        $tramitesEstado = collect([
            'Pendiente' => $tramitesRaw[0] ?? 0,
            'Entregado' => $tramitesRaw[1] ?? 0,
        ]);


        return view('home', compact(
            'adoptantesPorEstado',
            'nnaPorEdad',
            'nnaPorSexo',
            'nnaPorEstado',
            'asistenciasTotales',
            'participacionPorCapacitacion',
            'tramitesEstado',
        ));
    }
}
