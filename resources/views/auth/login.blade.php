@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Connexion</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
							<strong>Whoops!</strong> Une erreur est survenue.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Adresse E-Mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mot de passe</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Garder ma session active
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Connexion</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">vous avez oublié votre mot de passe ?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(':checkbox').radiocheck();
</script>
@endsection
