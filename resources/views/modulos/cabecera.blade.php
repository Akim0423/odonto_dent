<header class="main-header">
    <!-- Logo -->
    <a href="{{url('Inicio')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><i class="fa fa-tooth"></i></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Odonto</b>DENT <i class="fa fa-tooth"></i></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              @if (auth()->user()->foto == "")

                <img src="{{ url('storage/defecto.png') }}" class="user-image" alt="User Image">
              @else
              
                <img src="{{ url('storage/'.auth()->user()->foto) }}" class="user-image" alt="User Image">
              @endif

              <span class="hidden-xs">{{auth()->user()->name}} </span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{url('mis-datos')}}" class="btn btn-primary btn-flat">Mis Datos</a>
                </div>
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-danger btn-flat" onclick="event.preventDefault(); 
                  document.getElementById('logout-form').submit();">Cerrar Sesion</a>
                </div>

                <form action="{{route('logout')}}" method="POST" id="logout-form">
                  @csrf
                </form>

              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>