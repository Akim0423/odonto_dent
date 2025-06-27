@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1> Recordatorio a los Clientes</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">

                    <table class="table table-bordered table-hover table-striped">

                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Doctor</th>
                                <th>Correo</th>
                                <th>Motivo</th>
                                <th>Fecha Cita</th>

                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($citas as $cita)
                                <tr>
                                    <td>{{ $cita->cliente->nombre }}</td>
                                    <td>{{ $cita->doctor->name }}</td>
                                    <td>{{ $cita->cliente->email }}</td>
                                    <td>{{ $cita->especialidad->nombre }}</td>
                                    <td>{{ $cita->inicio }}</td>
                                    <td>
                                        @if ($cita->recordatorio_enviado)
                                            <button class="btn btn-success" disabled>
                                                <i class="fas fa-check"></i> Enviado
                                            </button>
                                        @else
                                            <form method="POST" action="{{ url('Enviar-Recordatorio') }}">
                                                @csrf
                                                <input type="hidden" name="id_cita" value="{{ $cita->id }}">
                                                <input type="hidden" name="email" value="{{ $cita->cliente->email ?? '' }}">
                                                <button type="submit" class="btn btn-primary">Enviar Recordatorio</button>
                                            </form>
                                        @endif
                                    </td>

                                    
                                </tr>
                            @endforeach

                            
                        </tbody>

                    </table>

                </div>

            </div>

        </section>
    </div>

@endsection