<?php

namespace App\Http\Controllers;

use App\Models\Ajustes;
use App\Models\User;
use App\Models\Clientes;
use App\Models\Citas;
use App\Models\Receta;
use App\Models\ImgHistorial;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;

class InformeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function informes()
    {
        // Conteos generales
        $usuarios = User::count(); // admin, odontólogo, secretaria
        $pacientes = Clientes::count();
        $odontologos = User::where('rol', 'doctor')->count();
        $secretarias = User::where('rol', 'secretaria')->count();
        $citas = Citas::count();
        $recetas = Receta::all()->count();
        $imagenes_subidas = ImgHistorial::count();
        $citas_realizadas = Citas::where('estado', 'realizada')->count();
        $citas_pendientes = Citas::where('estado', 'pendiente')->count();
        $citas_canceladas = Citas::where('estado', 'Cancelado')->count();

        // Ajustes del sistema
        $ajustes = Ajustes::find(1); // zona horaria
        date_default_timezone_set($ajustes["zona_horaria"]);

        // Establecer idioma español para nombres de meses
        setlocale(LC_TIME, 'es_ES.UTF-8'); // Para Linux
        setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para Windows

        // Datos de los últimos 6 meses
        $datosFinalizadas = [];
        $datosSolicitadas = [];
        $datosPendientes = [];
        $nombresMeses = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $mes = $fecha->format('m');
            $año = $fecha->format('Y');

            // Nombre del mes en español, primera letra mayúscula
            $nombresMeses[] = ucfirst(strftime('%B', strtotime($fecha)));

            $citasMes = Citas::whereYear('inicio', $año)->whereMonth('inicio', $mes)->get();

            $datosFinalizadas[] = $citasMes->where('estado', 'Finalizada')->count();
            $datosSolicitadas[] = $citasMes->where('estado', 'Solicitada')->count();
            $datosPendientes[] = $citasMes->where('estado', 'Pendiente')->count();
        }

        // Enviar datos a la vista
        return view('modulos.Informes', compact(
            'usuarios',
            'pacientes',
            'odontologos',
            'secretarias',
            'citas',
            'recetas',
            'citas_canceladas',
            'imagenes_subidas',
            'nombresMeses',
            'datosFinalizadas',
            'datosSolicitadas',
            'datosPendientes'
        ));
    }

    public function InformesPDF()
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('OdontoDent');
        $pdf->SetTitle('Informes');
        $pdf->SetMargins(10,10,10,false);
        $pdf->SetAutoPageBreak(true, 20);
        $pdf->AddPage();

        $ajustes = Ajustes::find(1);
        $usuarios = User::count(); // admin, odontólogo, secretaria
        $pacientes = Clientes::count();
        $odontologos = User::where('rol', 'doctor')->count();
        $secretarias = User::where('rol', 'secretaria')->count();
        $citas = Citas::count();
        $recetas = Receta::all()->count();
        $imagenes_subidas = ImgHistorial::count();
        $citas_canceladas = Citas::where('estado', 'Cancelado')->count();

        $html = '<h3>Informes</h3>
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr>
                                <th width:"25%">Usuarios</th>
                                <th width:"25%">Pacientes</th>
                                <th width:"25%">Odontologos</th>
                                <th width:"25%">Secretarias</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width:"25%">'.$usuarios.'</td>
                                <td width:"25%">'.$pacientes.'</td>
                                <td width:"25%">'.$odontologos.'</td>
                                <td width:"25%">'.$secretarias.'</td>
                            </tr>
                        </tbody>
                           
                        </table>';

        $html .= '
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr>
                                <th width:"25%">Citas Registradas</th>
                                <th width:"25%">Citas Canceladas</th>
                                <th width:"25%">Recetas Hechas</th>
                                <th width:"25%">Radiografias</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width:"25%">'.$citas.'</td>
                                <td width:"25%">'.$citas_canceladas.'</td>
                                <td width:"25%">'.$recetas.'</td>
                                <td width:"25%">'.$imagenes_subidas.'</td>
                            </tr>
                        </tbody>
                           
                        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output('Ventas.pdf', 'I');

    }
}
