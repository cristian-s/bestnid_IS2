@extends('layout.default')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Iniciar Sesion</div>
				<div class="panel-body">
					@include('partials.notifications')
					{{-- @if ((count($errors) > 0) || Session::has('error'))
						<div class="alert alert-danger">
							<strong>Opa!</strong> Parece que hubo algunos errores.<br><br>
							<ul>
								@if (Session::has('error'))
									<li> {{Session::get('error')}} </li>
								@endif
								@foreach ($errors as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif --}}

					<form class="form-horizontal" role="form" method="POST" action="{{ url('login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Usuario(E-mail)</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Contraseña</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						{{-- Funcion para recordar al usuario, para mas adelante --}}
						{{-- <div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div> --}}

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Iniciar Sesión</button>

								{{-- funcion para resetear la password, para mas adelante --}}
								{{-- <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a> --}}
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
