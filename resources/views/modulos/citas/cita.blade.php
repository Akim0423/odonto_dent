@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            
            <div class="row">

                <div class="col-md-3">
                    <h3><b>{{$cita->inicio}}</b></h3>
                </div>

                <div class="col-md-3">
                    <h3>Paciente: <b>{{$cliente->nombre}}</b></h3>
                </div>

                <div class="col-md-3">
                    @if ($cita->estado == 'En Proceso')
                        <h3><button class="btn btn-warning">En Proceso</button></h3>

                        <form action="{{url('Finalizar-Cita/'.$cita->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Finalizar</button>

                        </form>
                    @else
                        <h3><button class="btn btn-danger">Finalizada</button></h3>
                    @endif
                </div>

            </div>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">

                    <a href="">
                        <button class="btn btn-primary">Ver Historial Completo</button>
                    </a>

                    @if ($historial == '')
                        <form method="post">
                            @csrf

                            <input type="hidden" name="tipo" value="Agregar">

                            <h2>Nota: </h2>
                            <textarea name="nota" id="editor"></textarea>
                            <br>

                            <button class="btn btn-success" type="submit">Guardar en el historial</button>

                        </form>
                    @else
                        <form method="post">
                            @csrf

                            <input type="hidden" name="tipo" value="Actualizar">

                            <h2>Nota: </h2>
                            <textarea name="nota" id="editor">{!!$historial->nota!!}</textarea>
                            <br>

                            <button class="btn btn-success" type="submit">Guardar en el historial</button>

                        </form>
                    @endif

                </div>

            </div>

        </section>
    </div>

@endsection