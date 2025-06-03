@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1><i class="fas fa-user-injured"></i> Agregar Nuevo Clientes</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body">

                    <form action="" method="post">
                        @csrf

                        <div class="form-group">
                            <h2>Nombre y Apellido</h2>
                            <input type="text" class="form-control" name="nombre" required value="{{old('nombre')}}">
                        </div>

                        <div class="form-group">
                            <h2>Documento</h2>
                            <input type="text" class="form-control" name="documento" required value="{{old('documento')}}">
                            @error('documento')
                                <div class="alert alert-danger">El documento ya se encuentra registrado</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <h2>Email</h2>
                            <input type="email" class="form-control" name="email" required value="{{old('email')}}">
                            @error('email')
                                <div class="alert alert-danger">El email ya se encuentra registrado</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <h2>Telefono</h2>
                            <input type="text" class="form-control" name="telefono" required value="{{old('telefono')}}">
                        </div>

                        <div class="form-group">
                            <h2>Direccion</h2>
                            <input type="text" class="form-control" name="direccion" required value="{{old('direccion')}}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Agregar</button>

                    </form>

                </div>

            </div>

        </section>
    </div>

@endsection