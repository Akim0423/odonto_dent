@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1><i class="fas fa-head-side-mask"></i> Especialidades</h1>
            <br>
            
        </section>

        <section class="content">

            <div class="box">

                <div class="box-header">
                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CrearEspecialidad">Crear Especialidad</button>
                </div>

                <div class="box-body">
                    <h3>Especialidades</h3>
                    <table class="table table-bordered table-hover table-striped dt-responsive">

                        <thead>
                            <tr class="table-primary">
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Duracion Aprox</th>
                                <th>Estado</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($especialidades as $especialidad)
                                <tr>
                                    <td>{{$especialidad->id}}</td>
                                    <td>{{$especialidad->nombre}}</td>
                                    @php
                                        $tot = floatval($especialidad->precio);
                                        $precio = number_format($tot,2,'.',',');
                                    @endphp
                                    <td>S/ {{$precio}}</td>
                                    <td>{{$especialidad->duracion_aprox}} min.</td>
                                    <td>{{$especialidad->estado}}</td>

                                    <td>
                                        <a href="{{url('Editar-Especialidad/'.$especialidad->id)}}">                                       
                                            <button class="btn btn-success"><i class="fa fa-pencil"></i></button>
                                        </a>

                                        <a href="{{url('Eliminar-Especialidad/'.$especialidad->id)}}">
                                            <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </a>
                                    </td>

                                </tr>               
                            @endforeach
                                    
                                
                        </tbody>

                    </table>

                    <br><br>
                    @if (Auth::user()->rol == 'administrador' && count($especialidadesInactiva)>0)
                        <h3>Especialidades Inactivos</h3>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Duracion_aprox</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($especialidadesInactiva as $especialidad)
                                <tr>
                                    <td>{{ $especialidad->id }}</td>
                                    <td>{{ $especialidad->nombre }}</td>
                                    @php
                                        $tot = floatval($especialidad->precio);
                                        $precio = number_format($tot,2,'.',',');
                                    @endphp
                                    <td>S/ {{ $precio}}</td>
                                    <td>{{ $especialidad->duracion_aprox }} min</td>
                                    <td>
                                        <form method="POST" action="{{ url('Reactivar-Especialidad/'.$especialidad->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-warning" type="submit">Reactivar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>

            </div>

        </section>
    </div>

    <div id="CrearEspecialidad" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{url('Especialidad')}}" method="post">
                    @csrf
                    @method('put')

                    <div class="modal-body">

                        <div class="box-body">

                            <div class="form-group">

                                <h2>Nombre</h2>
                                <input type="text" name="nombre" class="form-control input-lg" value="{{old('nombre')}}" required>
                                @error('nombre')
                                    <div class="alert alert-danger">Esta Especialidad ya existe</div>
                                @enderror

                            </div>

                            <div class="form-group">

                                <h2>Precio</h2>
                                <input type="text" name="precio" class="form-control input-lg" value="{{old('precio')}}" required>
                            </div>

                            <div class="form-group">

                                <h2>Duracion_aprox</h2>
                                <input type="text" name="duracion_aprox" class="form-control input-lg" value="{{old('duracion_aprox')}}" required>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-primary" type="submit">Crear</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Cerrar</button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    @php
        $exp = explode('/',$_SERVER["REQUEST_URI"]);
    @endphp

    @if($exp[3] == 'Editar-Especialidad')
       <div id="EditarEspecialidad" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form action="{{url('Actualizar-Especialidad/'.$especialidad->id)}}" method="post">
                        @csrf
                        @method('put')

                        <div class="modal-body">

                            <div class="box-body">

                                <div class="form-group">

                                    <h2>Nombre</h2>
                                    <input type="text" name="nombre" class="form-control input-lg" value="{{$usuario->name}}" required>

                                </div>

                                <div class="form-group">
                                    <h2>Rol:</h2>
                                    <select class="form-control input-lg" name="rol" required>

                                        <option value="{{$usuario->rol}}">{{$usuario->rol}}</option>

                                        @php
                                            $roles=['administrador','veterinario','secretaria']
                                        @endphp

                                        @foreach($roles as $rol)
                                            @if($rol != $usuario->rol)

                                                <option value="{{$rol}}">{{$rol}}</option>

                                            @endif
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">

                                    <h2>Email</h2>
                                    <input type="text" name="email" class="form-control input-lg" value="{{$usuario->email}}" required>
                                    @error('email')
                                        <div class="alert alert-danger">El email ya existe</div>
                                    @enderror
                                </div>

                                <div class="form-group">

                                    <h2>Contraseña</h2>
                                    <input type="password" name="password" class="form-control input-lg" value="" >
                                    @error('password')
                                        <div class="alert alert-danger">La contraseña debe tener al menos 3 caracteres </div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-success" type="submit">Guardar</button>
                            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancelar</button>

                        </div>

                    </form>

                </div>

            </div>

        </div> 
    @endif

@endsection