<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Especialidad;
use App\Models\Ajustes;
use App\Models\User;
use App\Models\Citas;
use App\Models\Recordatorio;
use App\Mail\RecordatorioCita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Elibyy\TCPDF\Facades\TCPDF;

class ClientesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {

        $clientesActivos  = Clientes::where('estado', 1)->get();
        $clientesInactivos = Clientes::where('estado', 0)->get();
         
        return view('modulos.clientes.clientes', compact('clientesActivos', 'clientesInactivos'));
    }

    public function create()
    {
        return view('modulos.clientes.crear-clientes');
    }

    public function store(Request $request)
    {
        $datos = request()->validate([

            'nombre' =>["string",'max:255'],
            'email' =>["email",'unique:clientes'],
            'documento' =>["string",'unique:clientes'],
            'telefono' =>["string"],
            'direccion' =>["string"]
        ]);

        Clientes::create([

            'nombre'=>$datos["nombre"],
            'email'=>$datos["email"],
            'documento'=>$datos["documento"],
            'telefono'=>$datos["telefono"],
            'direccion'=>$datos["direccion"],
            'estado'=>1,
        ]);

        return redirect('Clientes')->with('ClienteAgregado', 'OK');
    }

    public function reactivar($id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->estado = 1;
        $cliente->save();

        return redirect('Clientes')->with('ClienteReactivado', 'OK');
    }

    public function update(Request $request, Clientes $clientes)
    {
        
    }

    public function destroy($id_clientes)
    {
        Clientes::where('id',$id_clientes)->update(['estado'=>0]);

        return redirect('Clientes');
    }

    public function Recordatorio()
    {
        // $citas = Citas::with('CLIENTE')
        //     ->whereBetween('inicio', [
        //         now()->addDay()->startOfDay(),
        //         now()->addDay()->endOfDay()
        //     ])
        //     ->where('estado', 'Solicitada')
        //     ->get();

        // return view('modulos.clientes.recordatorio', ['citas' => $citas]);

        // Obtener citas próximas (por ejemplo, las de los próximos 7 días)
        $citas = Citas::with(['cliente', 'especialidad'])
                    ->where('inicio', '>=', now())
                    ->where('inicio', '<=', now()->addDays(7))
                    ->orderBy('inicio', 'asc')
                    ->get();

        
        // Para cada cita, verificar si ya tiene recordatorio enviado
        // $citas = $citas->map(function($cita) {
        //     $recordatorio = Recordatorio::where('id_cita', $cita->id)
        //                             ->where('estado', 'Enviado')
        //                             ->latest('fecha_envio')
        //                             ->first();
            
        //     $cita->recordatorio_enviado = $recordatorio ? true : false;
        //     $cita->fecha_recordatorio = $recordatorio ? $recordatorio->fecha_envio : null;
            
        //     return $cita;
        // });

        foreach ($citas as $cita) {
            $recordatorio = Recordatorio::where('id_cita', $cita->id)
                                ->where('estado', 'like', 'Enviado%')
                                ->latest('fecha_envio')
                                ->first();

            $cita->recordatorio_enviado = $recordatorio ? true : false;
        }
        
        return view('modulos.clientes.recordatorio', compact('citas'));
    }

    public function EnviarRecordatorio(Request $request)
    {
        try {
            // Validar los datos
            $request->validate([
                'id_cita' => 'required|exists:citas,id',
                'email' => 'required|email'
            ]);

            // Obtener la cita con sus relaciones
            $cita = Citas::with(['cliente', 'especialidad','doctor'])
                        ->findOrFail($request->id_cita);

            
            if (!$cita->cliente || !$cita->cliente->email) {
                return redirect()->back()->with('error', 'No se encontró el cliente o el cliente no tiene correo.');
            }

            $ajustes = Ajustes::first();
            // Enviar el correo
            Mail::to($request->email)->send(new RecordatorioCita($cita,$ajustes));

            // Registrar el recordatorio en la base de datos
            Recordatorio::create([
                'id_cita' => $request->id_cita,
                'id_secretaria' => Auth::id(), // ID del usuario autenticado (secretaria)
                'email' => $request->email,
                'fecha_envio' => now()->format('Y-m-d H:i:s'),
                'estado' => 'Enviado'
            ]);

            // Opcional: Marcar que se envió el recordatorio
            $cita->update(['recordatorio_enviado' => true]);

            return redirect()->back()->with('success', 'Recordatorio enviado exitosamente a ' . $cita->cliente->nombre);

        } catch (\Exception $e) {
            // En caso de error, registrar el intento fallido
            Recordatorio::create([
                'id_cita' => $request->id_cita ?? 0,
                'id_secretaria' => Auth::id() ?? 0,
                'email' => $request->email ?? '',
                'fecha_envio' => now()->format('Y-m-d H:i:s'),
                'estado' => 'Error: ' .$e->getMessage()  // Limitar la longitud del mensaje
            ]);

            return redirect()->back()->with('error', 'Error al enviar el recordatorio: ' . $e->getMessage());
        }
    }    

    public function RecordatoriosPDF()
    {
        $pdf = new \Elibyy\TCPDF\TCPDF('P','mm','A4',true,'UTF-8',false);

        $pdf->SetCreator('OdontoDent');
        $pdf->SetTitle('Citas próximas - Recordatorio');
        $pdf->SetMargins(10,10,10,false);
        $pdf->SetAutoPageBreak(true,20);
        $pdf->AddPage();

        $ajustes = Ajustes::find(1);
        $logo = storage_path('app/public/logo.png');
        // $pdf->Image($logo, 150, 10 ,40, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);

        $citas = Citas::with(['cliente', 'especialidad'])
                    ->where('inicio', '>=', now())
                    ->where('inicio', '<=', now()->addDays(7))
                    ->orderBy('inicio', 'asc')
                    ->get();

        // Marcar si tiene recordatorio
        foreach ($citas as $cita) {
            $recordatorio = Recordatorio::where('id_cita', $cita->id)
                                ->where('estado', 'like', 'Enviado%')
                                ->latest('fecha_envio')
                                ->first();

            $cita->recordatorio_enviado = $recordatorio ? true : false;
            $cita->fecha_recordatorio = $recordatorio->fecha_envio ?? null;
        }

        $html = '<h2 style="text-align:center;"> Citas Próximas con Recordatorio</h2>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr style="background-color:#f2f2f2;">
                            <th width:"25%">Cliente</th>
                            <th width:"25%">Email</th>
                            <th width:"25%">Especialidad</th>
                            <th width:"25%">Fecha</th>
                            <th width:"25%">Hora</th>
                            <th width:"25%">Recordatorio</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($citas as $index => $cita) {
            $html .= '<tr>
                        <td>'.($index + 1).'</td>
                        <td>'.($cita->cliente->nombre ?? 'Sin nombre').'</td>
                        <td>'.($cita->cliente->email ?? 'Sin email').'</td>
                        <td>'.($cita->especialidad->nombre ?? 'Sin especialidad').'</td>
                        <td>'.\Carbon\Carbon::parse($cita->inicio)->format('d/m/Y').'</td>
                        <td>'.\Carbon\Carbon::parse($cita->inicio)->format('H:i').'</td>
                        <td>'.($cita->recordatorio_enviado ? ' Enviado' : ' No enviado').'</td>
                    </tr>';
        }

        $html .= '</tbody></table>';
        $html .= '<br><p style="text-align:center;">'.$ajustes->direccion.' | '.$ajustes->telefono.'</p>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Citas-Proximas-Recordatorio.pdf', 'I');
    }
}
