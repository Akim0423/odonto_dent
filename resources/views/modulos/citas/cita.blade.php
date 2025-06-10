@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            
            <div class="row">

                <div class="col-md-3">
                    <h3>Inicio: <b>{{$cita->inicio}}</b></h3>
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

                    <a href="{{url('Historial/'.$cita->id_cliente)}}">
                        <button class="btn btn-primary">Ver Historial Completo</button>
                    </a>
                    {{-- Receta --}}
                    @if ($receta == null)                        
                        <button class="btn btn-info pull-right" data-toggle="modal" data-target="#Receta">Receta</button>
                    @else

                        <a href="{{url('Receta-PDF/'.$receta->id)}}" target="_blank">
                            <button class="btn btn-default pull-right">Generar PDF</button>
                        </a>
                        
                        <button class="btn btn-info pull-right" data-toggle="modal" data-target="#RecetaEditar">Receta</button>
                    @endif
                    

                    {{-- Historial --}}
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

                        <hr>

                        <h2>Radiagrofias</h2>

                        <form method="post" enctype="multipart/form-data" action="{{url('Cita-Historial-Imagen/'.$historial->id_cita)}}">
                            @csrf
                            @method('put')
                            
                            <input type="file" name="imagenH" id="">
                            <br>
                            <button type="submit" class="btn btn-primary">Subir</button>

                        </form>

                        <br>

                        @foreach ($imagenes as $imagen)
                            <div class="col-md-3">

                                <form method="POST" action="{{url('Cita-Historial-Imagen-Borrar/'.$imagen->id)}}">
                                    @csrf
                                    @method('delete')

                                    <a href="{{ url('storage/'.$imagen->imagen) }}" target="_blank">
                                        <img src="{{url('storage/'.$imagen->imagen)}}" width="150px">
                                    </a>
                                    
                                    <button class="btn btn-danger" type="submit"><i class="fa fa-times"></i></button>
                                    
                                </form>

                            </div>
                        @endforeach
                    @endif

                </div>

            </div>

        </section>
    </div>

    {{-- Modales --}}
    <div id="Receta" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{url('Receta/'.$cita->id)}}">
                    @csrf

                    <div class="modal-body">

                        <div class="box-body">

                            <div class="form-group">
                                <h2>Receta:</h2>
                                <input type="hidden" name="tipo" value="Crear">
                                <textarea name="receta" id="editor2" required></textarea>
                            </div>

                            <input type="hidden" class="form-control input-lg" name="rol" value="veterinario" required>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Crear</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($receta != null)

        <div id="RecetaEditar" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{url('Receta/'.$cita->id)}}">
                        @csrf

                        <div class="modal-body">

                            <div class="box-body">

                                <div class="form-group">
                                    <h2>Receta:</h2>
                                    <input type="hidden" name="tipo" value="Actualizar">
                                    <textarea name="receta" id="editor3" required>{{$receta->receta}}</textarea>
                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Actualizar</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    @endif

@endsection