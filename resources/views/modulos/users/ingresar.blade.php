@extends('welcome')

@section('ingresar')
    
    <div class="login-box">
        <div class="login-logo">
            <a href="#">Odonto<b>Dent</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Ingresar al Sistema</p>

            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Correo" name="email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @error('email')
                        <br>
                        <div class="alert alert-danger">
                            Error con el correo o contraseña
                        </div>
                    @enderror
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    
                    <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


        </div>
        <!-- /.login-box-body -->
    </div>

@endsection