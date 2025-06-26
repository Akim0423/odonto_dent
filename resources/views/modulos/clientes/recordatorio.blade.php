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
                                <th>Correo</th>
                                <th>Motivo</th>
                                <th>Fecha Cita</th>

                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($citas as $cita)
                                <tr>
                                    <td>{{ $cita->CLIENTE->nombre }}</td>
                                    <td>{{ $cita->CLIENTE->email }}</td>
                                    <td>{{ $cita->ESPECIALIDAD->nombre }}</td>
                                    <td>{{ $cita->inicio }}</td>
                                    <td>
                                        <form method="POST" action="{{ url('Enviar-Recordatorio') }}">
                                            @csrf
                                            <input type="hidden" name="id_cita" value="{{ $cita->id }}">
                                            <input type="hidden" name="email" value="{{ $cita->CLIENTE->email }}">
                                            <button type="submit" class="btn btn-primary">Enviar Recordatorio</button>
                                        </form>
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