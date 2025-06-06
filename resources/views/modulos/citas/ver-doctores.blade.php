@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1><i class="fa fa-user-md"></i> Doctores</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-header">
                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CrearDoctor">Crear Doctor</button>
                </div>

                <div class="box-body">

                    <table class="table table-bordered table-hover table-striped dt-responsive">

                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Email</th>
                                <th>Foto</th>
                                <th>Estado</th>

                                <th></th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            @foreach ($doctores as $doctor)
                                <tr>

                                    <td>{{$doctor->name}}</td>
                                    <td>{{$doctor->email}}</td>
                                    @if ($doctor->foto == '')
                                        <td><img src="{{url('storage/defecto.png')}}" width="65px"></td>
                                    @else
                                        <td><img src="{{url('storage/'.$veterinario->foto)}}" width="50px"></td>
                                    @endif

                                    @if ($doctor->estado == 'Disponible')
                                        <td>

                                            <form action="{{url('Estado/'.$doctor->id)}}" method="post">
                                            
                                                @csrf
                                                @method('put')

                                                <input type="hidden" name="estado" value="No Disponible">

                                                <button type="submit" class="btn btn-success">Disponible</button>

                                            </form>

                                        </td>
                                    @else
                                        <td>

                                            <form action="{{url('Estado/'.$doctor->id)}}" method="post">
                                            
                                                @csrf
                                                @method('put')

                                                <input type="hidden" name="estado" value="Disponible">

                                                <button type="submit" class="btn btn-danger">No Disponible</button>

                                            </form>

                                        </td>
                                    @endif

                                    <td>

                                        <button class="btn btn-warning">Ver Citas Hoy</button>
                                        <button class="btn btn-primary">Ver Agenda Completa</button>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </section>
    </div>

    <div id="CrearDoctor" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <form method="post">
                    @csrf

                    <div class="modal-body">

                        <div class="box-body">

                            <div class="form-group">

                                <h2>Nombre y Apellido</h2>
                                <input type="text" name="name" class="form-control input-lg" value="{{old('name')}}" required>

                            </div>

                            <input type="hidden" name="rol" class="form-control input-lg" value="doctor" required>

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

@endsection