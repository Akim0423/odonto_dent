@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1><i class="fa fa-users"></i>Gestor de Usuarios</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-header">
                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CrearUsuario">Crear Usuario</button>
                </div>

                <div class="box-body">

                    <table class="table table-bordered table-hover table-striped dt-responsive">

                        <thead>
                            <tr class="table-primary">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Rol</th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>

                                    <td>
                                        @if ($user->foto != "")
                                            <img src="{{url('storage/'.$user->foto)}}" width="60px">
                                        @else
                                            <img src="{{url('storage/defecto.png')}}" width="60px">
                                        @endif
                                    
                                    </td>
                                    
                                    <td>{{$user->rol}}</td>

                                    <td>

                                        <a href="{{url('Editar-Usuario/'.$user->id)}}">                                       
                                            <button class="btn btn-success"><i class="fa fa-pencil"></i></button>
                                        </a>

                                        <button class="btn btn-danger EliminarUsuario" usuario="{{$user->name}}" Uid="{{$user->id}}"><i class="fa fa-trash"></i></button>

                                    </td>

                                </tr>               
                            @endforeach
                                    
                                
                        </tbody>

                    </table>

                </div>

            </div>

        </section>
    </div>

    <div id="CrearUsuario" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{url('Usuarios')}}" method="post">
                    @csrf
                    @method('put')

                    <div class="modal-body">

                        <div class="box-body">

                            <div class="form-group">

                                <h2>Nombre y Apellido</h2>
                                <input type="text" name="name" class="form-control input-lg" value="{{old('name')}}" required>

                            </div>

                            <div class="form-group">

                                <h2>Rol</h2>
                                <select name="rol" class="form-control input-lg" required>

                                    <option value="">Seleccionar...</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="secretaria">Secretaria</option>

                                </select>

                            </div>

                            <div class="form-group">

                                <h2>Email</h2>
                                <input type="text" name="email" class="form-control input-lg" value="{{old('email')}}" required>
                                @error('email')
                                    <div class="alert alert-danger">El email ya existe</div>
                                @enderror
                            </div>

                            <div class="form-group">

                                <h2>Contraseña</h2>
                                <input type="password" name="password" class="form-control input-lg" value="{{old('password')}}" required>
                                @error('password')
                                    <div class="alert alert-danger">La contraseña debe tener al menos 3 caracteres </div>
                                @enderror
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

    @if($exp[3] == 'Editar-Usuario')
       <div id="EditarUsuario" class="modal fade">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form action="{{url('Actualizar-Usuario/'.$usuario->id)}}" method="post">
                        @csrf
                        @method('put')

                        <div class="modal-body">

                            <div class="box-body">

                                <div class="form-group">

                                    <h2>Nombre y Apellido</h2>
                                    <input type="text" name="name" class="form-control input-lg" value="{{$usuario->name}}" required>

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