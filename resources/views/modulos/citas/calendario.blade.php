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

@endsection