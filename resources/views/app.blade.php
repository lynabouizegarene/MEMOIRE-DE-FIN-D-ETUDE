<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel </title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/font-awesome-4.3.0/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/timeline.css') }}" rel="stylesheet">
	<link href="{{ asset('Flat-UI-master/dist/css/flat-ui.css') }}" rel="stylesheet">

	<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    @yield('maps_script')
	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<!--
	<link href='http://fonts.googleapis.com/css?family=Nixie+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Akronim' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Qwigley' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>
	-->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body @yield('maps_onload')>
    <nav class="navbar navbar-inverse navbar-fixed-top" id="navbar">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{url('/')}}">Nom du site</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if (Auth::check())
					<li @yield('activeAccueil')><a href="{{ route('home') }}">Accueil</a></li>
					<li @yield('activeMesCovoiturages')><a href="{{ route('covoiturage/index') }}">Mes Covoiturages</a></li>
				    @endif
				    <li @yield('activePublier')><a href="{{ route('covoiturage/create') }}">Publier</a></li>
				    <li @yield('activeCcm')><a href="{{ route('comment_ca_marche') }}">Comment ça marche?</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Connexion</a></li>
						<li><a href="{{ url('/auth/register') }}">S'inscrire</a></li>
					@else

                        <?php
                            $notifications = \Illuminate\Support\Facades\Auth::User()->notifications()->where('vu','=','0')->get();
                            $nb_notif = $notifications->count();
                        ?>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="glyphicon glyphicon-bell"></span>
                                <span class="badge" style="background-color: #ffffff; color: #34495e">{{$nb_notif}}</span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                 @foreach($notifications as $notification)

                                   <li id="notif{{$notification->id}}">
                                   <a href="{{route('notificationVu',$notification->id)}}">
                                       {{$notification->contenu}}<br>
                                       {{\Carbon\Carbon::createFromTimestamp(strtotime($notification->created_at))->diffForHumans()}}
                                   </a>
                                   </li>
                                 @endforeach
                                 <li role="presentation" class="divider"></li>
                                 <li class="text-center"><a href="{{route('notifier')}}">Toutes les notifications</a></li>
                            </ul>
                        </li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->prenom }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							    <li>
                            	    <a href="{{route('user/edit')}}">
                                    <i class="fa fa-pencil-square-o"></i> Editer mon profil</a>
                            	</li>
								<li>
								    <a href="{{ url('/auth/logout') }}">
								    <span class="glyphicon glyphicon-off"></span> Logout</a>
								</li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
	<script src="{{ asset('Flat-UI-master/dist/js/flat-ui.min.js') }}"></script>
	<script src="{{ asset('Flat-UI-master/docs/assets/js/application.js') }}"></script>

    @if (Auth::check())
        @if($nb_notif >0)
            <script>
                @foreach($notifications as $notification)
                    $("#notif{{$notification->id}}")
                @endforeach
            </script>
        @endif
    @endif

    @yield('script_ajax')
    @yield('script_register')
    @yield('script_maps_autocomplete')
</body>
</html>
