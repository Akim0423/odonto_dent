<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OdontoDent</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Version Actualizada de Font Awesome -->
  <script src="https://kit.fontawesome.com/3c836c2d8d.js" crossorigin="anonymous"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ url('dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ url('bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ url('bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
 
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!--DataTables-->
  <link rel="stylesheet" href="{{url('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{url('bower_components/datatables.net-bs/css/responsive.bootstrap.min.css')}}">

  <!--Select2-->
  <link rel="stylesheet" href="{{url('bower_components/select2/dist/css/select2.min.css')}}">

  <!-- FullCalendar -->  

  <link rel="stylesheet" href="{{url('bower_components\fullcalendar\dist\fullcalendar.min.css')}}">
  <link rel="stylesheet" href="{{url('bower_components\fullcalendar\dist\fullcalendar.print.min.css')}}" media="print">

  <!--CKeditor-->
  <script src="{{ url('bower_components/ckeditor/ckeditor.js') }}"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Icono de pestaña -->
  <link rel="icon" type="image/png" href="{{ asset('storage/logo.png') }}?v={{ time() }}">

  <link rel="stylesheet" href="{{asset('css/main.css')}}">

</head>
<body class="hold-transition skin-blue sidebar-mini login-page">

    @if(Auth::user())
        <div class="wrapper">
            @include('modulos.cabecera')

            @if (auth()->user()->rol == 'doctor')
                @include('modulos.menuDoc')
            @else
                @include('modulos.menu')
            @endif

            @yield('contenido')
        </div>    

    @else

        @yield('ingresar')

    @endif
</div>
<!-- jQuery 3 -->
<script src="{{ url('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ url('bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{ url('bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ url('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ url('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ url('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ url('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ url('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('dist/js/demo.js')}}"></script>

<script text="text/javascript" src="{{ url('bower_components/input-mask/jquery.inputmask.js') }}"></script>

<!-- DataTables -->

<script text="text/javascript" src="{{ url('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script text="text/javascript" src="{{ url('bower_components/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
<script text="text/javascript" src="{{ url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>


<!-- Select2 -->

<script text="text/javascript" src="{{ url('bower_components/select2/dist/js/select2.min.js') }}"></script>

<!-- FullCalendar -->

<script type="text/javascript" src="{{ url('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="{{ url('bower_components/fullcalendar/dist/locale/es.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tablas y demas -->
<script type="text/javascript">

  $(".sidebar-menu").tree();

  $("[data-mask]").inputmask();

  $("table.table").DataTable({
      
      // "ordering": false,
      "language": {
        "sSearch": "Buscar:",
        "sEmptyTable": "No hay datos en la Tabla",
        "sZeroRecords": "No se encontraron resultados",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrando de un total de _MAX_ registros)",
        "sLoadingRecords": "Cargando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        }
      }
  });

  $(".select2").select2();

  CKEDITOR.replace('editor');

</script>

<!--ALERTAS-->
<script type="text/javascript">

  @if(session('UsuarioCreado')=='OK')
      Swal.fire(
        'El Usuario ha sido Creado',
        '',
        'success'
      )

  @elseif(session('UsuarioActualizado')=='OK')
      Swal.fire(
        'El Usuario ha sido Actualizado',
        '',
        'success'
      )
  @elseif(session('ClienteAgregado')=='OK')
      Swal.fire(
        'El Cliente ha sido Agregado',
        '',
        'success'
      )
  @elseif(session('DoctorCreado')=='OK')
      Swal.fire(
        'El Doctor ha sido Agregado',
        '',
        'success'
      )
  @elseif(session('CitaAgendada')=='OK')
      Swal.fire(
        'La Cita ha sido Agendada',
        '',
        'success'
      )
  @elseif(session('HistorialAgredado')=='OK')
      Swal.fire(
        'El Historial ha sido Agregado',
        '',
        'success'
      )
  @elseif(session('HistorialActualizado')=='OK')
      Swal.fire(
        'El Historial ha sido Actualizado',
        '',
        'success'
      )
  
  @endif    

</script>

@php
    $exp = explode('/', $_SERVER["REQUEST_URI"]);
@endphp

@if (isset($exp[3]) && $exp[3] == 'Editar-Usuario')
    <script type="text/javascript">
        $('#EditarUsuario').modal('toggle');
    </script>
@endif

<script type="text/javascript">

  $(".table").on('click','.EliminarUsuario', function() {
    
    var Uid = $(this).attr('Uid');
    var usuario= $(this).attr('usuario');

    Swal.fire({

      title:'¿Seguro que desea eliminar el usuario: '+usuario+'?',
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      confirmButtonColor: '#3085d6'
    }).then((result)=> {

      if(result.isConfirmed){
        
        window.location = 'Eliminar-Usuario/'+Uid;
      }
    })

  })

</script>

<!-- Calendario -->
@if ($exp[3] == 'Calendario')

  <script type="text/javascript">

    var date= new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var a = date.getFullYear();

    $("#calendario").fullCalendar({

      defaultView: 'agendaWeek',
      hiddenDays: [0],

      events: [

          @foreach($citas as $cita)

              @foreach($clientes as $cliente)

                @if($cita->id_cliente == $cliente->id)

                  @if($cita->estado == 'Solicitada')

                    {
                      id: '{{$cita->id}}',
                      title: '{{$cliente->nombre}} - {{$cliente->documento}} | {{$cita->estado}}',
                      start: '{{$cita->inicio}}',
                      end: '{{$cita->fin}}', 
                      backgroundColor: '#1C72FF',
                      borderColor: '1C72FF',
                      estado: '{{$cita->estado}}',
                    },
                  @elseif($cita->estado == 'Finalizada')  
                    {
                      id: '{{$cita->id}}',
                      title: '{{$cliente->nombre}} - {{$cliente->documento}} | {{$cita->estado}}',
                      start: '{{$cita->inicio}}',
                      end: '{{$cita->fin}}', 
                      backgroundColor: '#0FA603',
                      borderColor: '#0FA603',
                      estado: '{{$cita->estado}}',
                    },
                  @elseif($cita->estado == 'En Proceso')  
                    {
                      id: '{{$cita->id}}',
                      title: '{{$cliente->nombre}} - {{$cliente->documento  }} | {{$cita->estado}}',
                      start: '{{$cita->inicio}}',
                      end: '{{$cita->fin}}', 
                      backgroundColor: '#D88B03',
                      borderColor: '#D88B03',
                      estado: '{{$cita->estado}}',
                    },  
                  @endif

                @endif

              @endforeach

          @endforeach

      ],

        scrollTime: '09:00',
        minTime: '09:00',
        maxTime: '18:00',

        dayClick: function(date,jsEvent,view){

          var fecha = date.format();
          fecha = fecha.split("T");
          var fechaParte = fecha[0];
          var horaParte = fecha[1].substring(0, 5); // Obtener HH:MM

          var ahora = new Date();
          var añoActual = ahora.getFullYear();
          var mesActual = (ahora.getMonth() + 1).toString().padStart(2, '0');
          var diaActual = ahora.getDate().toString().padStart(2, '0');
          var horaActual = ahora.getHours().toString().padStart(2, '0');
          var minutoActual = ahora.getMinutes().toString().padStart(2, '0');

          var fechaHoraActual = añoActual + "-" + mesActual + "-" + diaActual + " " + horaActual + ":" + minutoActual;
          var fechaHoraSeleccionada = fechaParte + " " + horaParte;

          if (fechaHoraSeleccionada >= fechaHoraActual) {

            @if ($doctor->estado == 'Disponible')
              $("#CitaModal").modal();
            @endif

            $("#fecha").val(fechaParte);
            $("#hora").val(horaParte);

            var horaModal= fecha[1].split(":");

            if (horaModal[1] == '00') {
            var horaFin = horaModal[0];
            var minutoFin = '30';
            }else{
            var horaFin = parseFloat(horaModal[0]) + 1;
            var minutoFin = '00';
            }

            $("#fyhInicial").val(fechaParte+' '+horaParte+':00');
            $("#fyhFinal").val(fechaParte+' '+horaFin+':'+minutoFin+':00');

          } else {
            Swal.fire({
              icon: 'warning',
              title: '¡Advertencia!',
            text: 'No puedes agendar citas en el pasado.',
            });
          }
        },

        eventClick: function(calEvent, jsEvent, view){
          if (calEvent.estado === 'Solicitada' || calEvent.estado === 'En Proceso') {
            $("#CancelarCita").modal();
            $("#paciente").html(calEvent.title);
            $("#CitaId").val(calEvent.id);
          }
        }

    });

  </script>

@endif


</body>
</html>
