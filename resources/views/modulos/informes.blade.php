@extends('welcome')
@section('contenido')
    
    <div class="content-wrapper">

        <section class="content-header">
            <h1><i class="fa fa-bar-chart"></i> Informes <a href="{{url('InformesPDF')}}" target="_blank">
                <button type="button" class="btn btn-default">PDF</button></a></h1>
        </section>

        <section class="content">

            <div class="box">
                <div class="row">

                    <!-- Usuarios -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-navy"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Usuarios</span>
                                <span class="info-box-number">{{ $usuarios }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pacientes -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pacientes</span>
                                <span class="info-box-number">{{ $pacientes }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Odontólogos -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-user-md"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Odontólogos</span>
                                <span class="info-box-number">{{ $odontologos }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Secretarias -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-orange"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Secretarias</span>
                                <span class="info-box-number">{{ $secretarias }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Citas Registradas-->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-purple"><i class="fa fa-calendar-check-o"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Citas Registradas</span>
                                <span class="info-box-number">{{ $citas }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Citas Canceladas-->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-red"><i class="fas fa-calendar-times"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Citas Canceladas</span>
                                <span class="info-box-number">{{ $citas_canceladas }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recetas -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fas fa-book-medical"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Recetas Hechas</span>
                                <span class="info-box-number">{{ $recetas }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Radiografias -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-teal"><i class="fas fa-book-medical"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Radiografias</span>
                                <span class="info-box-number">{{ $imagenes_subidas }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            <hr>

            <!-- Gráfico -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Citas en los últimos 6 meses</h3>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height: 350px;"></canvas>
                    </div>
                </div>
            </div>
        </div>


        </section>
    </div>

@endsection