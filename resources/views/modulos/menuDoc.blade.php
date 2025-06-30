<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">

        <li>
          <a href="{{ url('Inicio') }}">
            <i class="fa fa-home"></i> <span>Inicio</span>
          </a>
        </li>

        <li>
          <a href="{{ url('Clientes') }}">
            <i class="fas fa-user-injured"></i> <span> Clientes</span>
          </a>
        </li>

        <li class="treeview">

          <a href="#">
            <i class="fa-solid fa-house-medical-flag"></i> <span>Clinica</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">

            <li>
              @php
                use App\Models\Citas;
                use App\Models\Ajustes;
                use Carbon\Carbon;

                $ajustes = Ajustes::find(1);
                date_default_timezone_set($ajustes->zona_horaria);
                $fechaHoy = date('Y-m-d');

                $cantidadCitasHoy = Citas::where('id_doctor', auth()->id())
                    ->where('inicio', 'like', $fechaHoy.'%')
                    ->count();
              @endphp
              <a href="{{ url('Citas-Hoy/'.auth()->user()->id) }}">
                <i class="fa fa-calendar-check-o"></i> 
                <span>Citas</span>

                @if($cantidadCitasHoy > 0)
                  <span class="label label-success pull-right">{{ $cantidadCitasHoy }}</span>
                @endif
              </a>

            </li>

          </ul>

        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>