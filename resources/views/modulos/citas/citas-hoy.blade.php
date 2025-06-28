@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">

            @php
                
                $fechaHoy = date('d/m/Y');

            @endphp

            <h1><i class="fa fa-user-md"></i> Citas de Hoy: <b>{{$fechaHoy}}</b> - Veterinario: <b>{{$doctor->name}}</b></h1>

            @if (auth()->user()->rol == 'doctor')
                <br>
                <a href="{{url('Calendario/'.auth()->user()->id)}}">
                    <button class="btn btn-info">Ver Calendario Completo</button>
                </a>
                
            @endif
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">

                    <table class="table table-bordered table-hover table-striped dt-responsive">

                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Especialidad</th>
                                <th>Nota</th>

                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($citas as $cita)
                                @php
                                    $fyh = explode(' ',$cita->inicio);
                                    $hora = substr($fyh[1],0,5) ;
                                @endphp
                                <tr>
                                    <td>{{$hora}}</td>
                                    <td>{{$cita->CLIENTE->nombre}}</td>
                                    <td>{{$cita->ESPECIALIDAD->nombre}}</td>
                                    <td>{!!$cita->nota!!}</td>

                                    <td>

                                        @if (auth()->user()->rol == 'doctor')
                                            <form method="post">
                                                @csrf

                                                <input type="hidden" name="id_cita" value="{{$cita->id}}">

                                                @if ($cita->estado == 'Solicitada')
                                                    <input type="hidden" name="estado" value="En Proceso">
                                                    <button type="submit" class="btn btn-primary">Comenzar</button>

                                                @elseif ($cita->estado == 'En Proceso')                                                  

                                                    <button type="button" class="btn btn-warning">En Proceso</button>
                                                    <input type="hidden" name="estado" value="Finalizada">
                                                    <button type="submit" class="btn btn-danger">Finalizar</button>
                                                    <a href="{{url('Cita/'.$cita->id)}}">
                                                        <button type="button" class="btn btn-primary">Ir a la Cita</button>
                                                    </a>
                                                @else

                                                    <button type="button" class="btn btn-danger">Finalizada</button>
                                                @endif
                                            
                                            </form>                                          
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <h2>Citas Anteriores</h2>

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Especialidad</th>
                                <th>Nota</th>
                                <th>Historial Clinico</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($citasHistorial as $citaH)
                                @php
                                    $fyh = explode(' ',$citaH->inicio);
                                    $hora = substr($fyh[1],0,5) ;
                                @endphp
                                <tr>
                                    <td>{{$citaH->inicio}}</td>
                                    <td>{{$citaH->CLIENTE->nombre}}</td>
                                    <td>{{$citaH->ESPECIALIDAD->nombre}}</td>
                                    <td>{!!$citaH->nota!!}</td>

                                    <td>
                                        <a href="{{url('Cita/'.$citaH->id)}}">
                                            <button type="button" class="btn btn-primary">Ver Historial</button>
                                        </a>
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