@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper transitionIn-Y-bottom">

        <section class="content-header transitionIn-Y-over">
            <h1><i class="fas fa-user-injured"></i> Gestor de Pacientes</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-header">
                    @if (Auth::user()->rol == 'administrador')
                        <a href="{{url('Crear-Cliente')}}">
                            <button class="btn btn-primary">Agregar Nuevo Pacientes</button>
                        </a>
                    @endif

                </div>

                <div class="box-body transitionIn-Y-bottom">
                    <h3>Clientes</h3>
                    <table class="table table-bordered table-striped table-hover">

                        <thead>
                            <tr>
                                <th>Pacientes</th>
                                <th>Documento</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                                
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($clientesActivos as $cliente)
                                
                            <tr>
                                <td>{{$cliente->nombre}}</td>
                                <td>{{$cliente->documento}}</td>
                                <td>{{$cliente->email}}</td>
                                <td>{{$cliente->telefono}}</td>
                                <td>{{$cliente->direccion}}</td>

                                <td>
                                    <td>

                                        @if (in_array(Auth::user()->rol, ['administrador', 'secretaria']))
                                            <a href="{{ url('Editar-Cliente/'.$cliente->id) }}">
                                                <button class="btn btn-success"><i class="fa fa-pencil"></i></button>
                                            </a>
                                        @endif

                                        @if (Auth::user()->rol == 'administrador')
                                            <a href="{{ url('Eliminar-Cliente/'.$cliente->id) }}">
                                                <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </a>
                                        @endif

                                        <a href="{{ url('Historial/'.$cliente->id) }}">
                                            <button type="button" class="btn btn-info"><i class="fas fa-file-medical"></i></button>
                                        </a>
                                    </td>

                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                    <br><br>
                    @if (Auth::user()->rol == 'administrador' && count($clientesInactivos)>0)
                        <h3>Clientes Inactivos</h3>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Pacientes</th>
                                    <th>Documento</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientesInactivos as $cliente)
                                <tr>
                                    <td>{{ $cliente->nombre }}</td>
                                    <td>{{ $cliente->documento }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->telefono }}</td>
                                    <td>{{ $cliente->direccion }}</td>
                                    <td>
                                        <form method="POST" action="{{ url('Reactivar-Cliente/'.$cliente->id) }}">
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

@endsection