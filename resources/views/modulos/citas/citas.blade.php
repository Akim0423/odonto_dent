@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper transitionIn-Y-bottom">

        <section class="content-header transitionIn-Y-over">
            <h1><i class="fa fa-stethoscope"></i>Elija un Doctor</h1>
        </section>

        <section class="content">

            <div class="box">

                <div class="box-body transitionIn-Y-bottom">

                    @foreach ($doctores as $doctor)
                        
                        <div class="col-md-3 col-sm-6">

                            @if ($doctor->estado == 'Disponible')
                                <div class="box box-success">
                                </div>
                            @else
                                <div class="box box-danger"> 
                                </div>
                            @endif

                                <div class="box-boby box-profile">
                                    @if ($doctor->foto == '')
                                        <img src="{{url('storage/defecto.png')}}" class="profile-user-img img-responsive img-circle" >
                                    @else
                                        <img src="{{url('storage/'.$doctor->foto)}}" class="profile-user-img img-responsive img-circle" >
                                    @endif

                                    <h3 class="profile-username text-center">{{$doctor->name}}</h3>

                                    @if ($doctor->estado == 'Disponible')
                                        <p class="text-muted text-center" style="color:#00a65a;">Disponible</p>
                                    @else
                                        <p class="text-muted text-center" style="color:#f56954;">Disponible</p>
                                    @endif

                                    <a href="{{ url('Calendario/'.$doctor->id) }}" class="btn btn-primary btn-block"><b>Ver Calendario</b></a>


                                </div>
                            

                        </div>

                    @endforeach

                </div>

            </div>

        </section>
    </div>

@endsection