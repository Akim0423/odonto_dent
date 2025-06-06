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
          <a href="{{ url('Usuarios') }}">
            <i class="fa fa-users"></i> <span>Usuarios</span>
          </a>
        </li>

        <li>
          <a href="{{ url('Clientes') }}">
            <i class="fas fa-user-injured"></i> <span> Clientes</span>
          </a>
        </li>

        {{-- <li>
          <a href="{{ url('Mascotas') }}">
            <i class="fa fa-book"></i> <span>Pacientes</span>
          </a>  
        </li> --}}

        <li class="treeview">

          <a href="#">
            <i class="fa-solid fa-house-medical-flag"></i> <span>Clinica</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">

            <li>
              <a href="{{ url('Doctores') }}">
                <i class="fa fa-medkit"></i> 
                <span>Doctores</span>
              </a>
            </li>

            <li>
              <a href="{{ url('Citas') }}">
                <i class="fa fa-calendar-check-o"></i> 
                <span>Citas</span>
              </a>
            </li>

          </ul>

        </li>

        <hr>

        <li>
          <a href="{{ url('Informes') }}">
            <i class="fa fa-bar-chart"></i> 
            <span>Informes</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>