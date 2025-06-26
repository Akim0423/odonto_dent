@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h2>Doctor: {{$doctor->name}}</h2>
            @if ($doctor->estado == 'Disponible')
                <h2>Estado: <button class="btn btn-success">Disponible</button></h2>
            @else
                <h2>Estado: <button class="btn btn-danger">No Disponible</button></h2>
            @endif
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">

                    <div id="calendario"></div>

                </div>

            </div>

        </section>
    </div>



    <div id="CitaModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{url('Calendario/'.$doctor->id)}}">
                    @csrf

                    <div class="modal-body">

                        <div class="box-body">
                  
                            <input type="hidden" class="form-control input-lg" name="id_doctor" 
                            value="{{ $doctor->id }}" required>
                            
                            <div class="form-group">
                                <h2>Cliente:</h2>
                                <select class="form-control input-lg select2" name="id_cliente" id="cliente" required 
                                style="width:100%;" url="{{url('')}}">

                                    <option value="">Seleccionar...</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{$cliente->id}}">{{$cliente->nombre}} - {{$cliente->documento}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group">
                                <h2>Especialidad</h2>
                                <select id="especialidad" name="id_especialidad" class="form-control input-lg select2" 
                                style="width: 100%;" required>
                                    <option value="" data-duracion="0">Seleccionar</option>
                                    @foreach($especialidades as $esp)
                                    <option value="{{ $esp->id }}" data-duracion="{{ $esp->duracion_aprox }}">
                                        {{ $esp->nombre }}  -  S/ {{$esp->precio}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <h2>Fecha:</h2>
                                <input type="text" class="form-control input-lg" id="fecha" readonly>

                            </div>

                            <div class="form-group">
                                <h2>Hora:</h2>
                                <input type="text" class="form-control input-lg" id="hora" readonly>

                            </div>

                            <input type="hidden" name="inicio" id="fyhInicial">
                            <input type="hidden" name="fin" id="fyhFinal">

                            <div class="form-group">
                                <h2>Nota:</h2>
                                <textarea name="nota" id="editor" ></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Agendar Cita</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="CancelarCita" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{url('Cancelar-Cita')}}">
                    @csrf
                    @method('delete')

                    <div class="modal-body">

                        <div class="box-body">
                  
                            <input type="hidden" class="form-control input-lg" name="id_doctor" 
                            value="{{ $doctor->id }}" required>

                            <div class="form-group">
                                <h2>Paciente:</h2>
                                <h3 id="paciente"></h3>

                                <input type="hidden" name="id_cita" id="CitaId">

                            </div>

                            <div class="form-group">
                                <h2>Especialidad:</h2>
                                <h3 id="especialidad_text"></h3>

                                <input type="hidden" name="id_especialidad" id="EspecialidadId">
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-warning" type="submit">Cancelar Cita</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection