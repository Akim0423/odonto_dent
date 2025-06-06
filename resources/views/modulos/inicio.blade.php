@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1>Inicio</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">

                    @if (auth()->user()->rol == 'administrador')

                        <form method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-3">
                                <h2>Logo</h2>
                                <input type="file" class="form-control" name="logo">
                                <img src="{{ url('storage/logo.png') }}" alt="Imagen Logo" width="250px">
                            </div>

                            <div class="col-md-3">
                                <h2>Telefono</h2>
                                <input type="text" class="form-control" name="telefono" required
                                data-inputmask="'mask': '+(99) 999-999999'" data-mask 
                                value="{{$ajustes->telefono}}">
                            </div>

                            <div class="col-md-3">
                                <h2>Direccion</h2>
                                <input type="text" class="form-control" name="direccion" required 
                                value="{{$ajustes->direccion}}">
                            </div>

                            <div class="col-md-3">
                                <h2>Zona horaria:</h2>
                                <select class="form-control" name="zona_horaria" required>
                                    <option value="{{$ajustes->zona_horaria}}">{{$ajustes->zona_horaria}}</option>

                                    @php
                                        $zonas = ['America/Lima', 'America/El_Salvador','America/Bogota'];
                                    @endphp

                                    @foreach ($zonas as $zona)
                                        @if ($zona != $ajustes->zona_horaria )
                                            <option value="{{$zona}}">{{$zona}}</option>
                                        @endif
                                        
                                    @endforeach
                                </select> 
                            </div>

                            <div class="col-md-3">
                                <h2></h2><br><br>
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </form>

                    @elseif(auth()->user()->rol == 'doctor')
                        <div class="filter-container doctor-header">

                            <h3 class="saludo">Bienvenido!</h3>
                            <h1 class="nombre">{{ auth()->user()->name }}.</h1>
                            <p class="bienvenida">
                                Gracias por unirse a nosotros. ¡Siempre estamos tratando de ofrecer un servicio completo!<br>
                                Puedes ver tu agenda diaria y llegar a cita con el paciente desde casa.<br><br>
                            </p>
                            {{-- <a href="{{ route('citas.index') }}" class="non-style-link">
                                <button class="btn-primary btn" style="width:30%">Ver mis Citas</button>
                            </a> --}}
                            <br><br>

                        </div>
                                    

                    @elseif(auth()->user()->rol == 'secretaria')
                        
                        <div class="filter-container secretaria-header">

                            <h3 class="saludo">¡Bienvenida!</h3>
                            <h1 class="nombre">{{ auth()->user()->name }}.</h1>
                            <p class="bienvenida">
                                Gracias por tu trabajo. Desde este panel puedes gestionar fácilmente las citas de los pacientes, 
                                coordinar con los doctores y mantener actualizada la agenda del consultorio.<br><br>
                                Recuerda confirmar las citas del día y registrar nuevos pacientes cuando sea necesario.<br><br>
                            </p>

                            <br><br>

                        </div>

                                       
                    @endif

                </div>

            </div>

        </section>
    </div>

@endsection