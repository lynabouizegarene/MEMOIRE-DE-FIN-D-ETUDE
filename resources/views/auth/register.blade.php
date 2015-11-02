@extends('app')

@section('content')
<link href="{{ asset('css/bootstrap-datepicker3.standalone.min.css')}}" rel="stylesheet">


<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Inscription</h4></div>
				<div class="panel-body">
					@if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
							<strong>Whoops!</strong> Une erreur est survenue.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									@if(!empty($error))
                                    <li>{{ $error }}</li>
                                    @endif
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="well text-center"><h4>Vos coordonnées</h4></div>

						<div class="form-group">
							<label class="col-md-4 control-label">Adresse E-Mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Mot de passe</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirmation</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Nom</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-4 control-label">Prenom</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required>
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-4 control-label">Civilité</label>
							<div class="col-md-6">
							    <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default active">
                                    <input type="radio" name="genre" value="Homme" checked> Homme
                                  </label>
                                  <label class="btn btn-default">
                                    <input type="radio" name="genre" value="Femme"> Femme
                                  </label>
                                </div>
                            </div>
						</div>

						<div class="form-group">
                            <label class="col-md-4 control-label">Date de naissance</label>
                        	<div class="col-md-6">
                        		<input type="text" class="form-control" id="datepicker" name="date_nais" value="{{ old('date_nais') }}" required>
                        	</div>
                        </div>

                        <div class="form-group">
							<label class="col-md-4 control-label">Numéro de téléphone</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="num_tel" value="{{ old('num_tel') }}" required pattern="^0[0-9]{8,9}$">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Ville</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="autocomplete"  value="{{ old('autocomplete') }}" required>
							</div>
						</div>
                        <!-- hidden-->
                         <input type="hidden"  id="ville"  class="form-control" name="ville" value="{{ old('ville') }}">
                         <input type="hidden"  id="wilaya" class="form-control" name="wilaya" value="{{ old('wilaya') }}">
                         <input type="hidden"  id="geoloc" class="form-control" name="geoloc" value="{{ old('geoloc') }}">
                        <!-- hidden fin-->
                        <div class="well text-center"><h4>vos préférences de voyage</h4></div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Musique</label>
                        	<div class="col-md-6">
                                <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default active">
                                    <input type="radio" name="pref_musique" value="1" checked> Oui
                                  </label>
                                  <label class="btn btn-default">
                                    <input type="radio" name="pref_musique" value="0"> Non
                                  </label>
                                </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Animeaux</label>
                        	<div class="col-md-6">
                        	    <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default active">
                                    <input type="radio" name="pref_animeaux" value="1" checked> Oui
                                  </label>
                                  <label class="btn btn-default">
                                    <input type="radio" name="pref_animeaux" value="0"> Non
                                  </label>
                                </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Discussion</label>
                        	<div class="col-md-6">
                        	  <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default active">
                                  <input type="radio" name="pref_discussion" value="1" checked> Oui
                                </label>
                                <label class="btn btn-default">
                                  <input type="radio" name="pref_discussion" value="0"> Non
                                </label>
                              </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Fumeur</label>
                        	<div class="col-md-6">
                        	    <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default active">
                                    <input type="radio" name="pref_fumeur" value="1" checked> Oui
                                  </label>
                                  <label class="btn btn-default">
                                    <input type="radio" name="pref_fumeur" value="0"> Non
                                  </label>
                                </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Présentation</label>
                        	<div class="col-md-6">
                        		<textarea class="form-control" name="description" rows="6" style="resize:none">{{ old('description') }}</textarea>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Votre photo</label>
                        	<div class="col-md-6">
                        		<input type="file" name="photo">
                        	</div>
                        </div>

                        <div class="form-group">
                            <div class="g-recaptcha col-md-offset-4" data-sitekey="6LdBCAYTAAAAAIUdAbpVGM-wWR2ByhKJzWhuAtDZ" style="padding: 15px"></div>
                        </div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									S'inscrire
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('maps_onload')
    onload="initialize()"
@endsection

@section('maps_script')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places&language=fr&region=dz"></script>
@endsection

@section('script_register')

    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('locales/bootstrap-datepicker.fr-CH.min.js')}}"></script>
	<script>
        $('#datepicker').datepicker({
            format: "yyyy-mm-dd",
            weekStart: 7,
            startDate: "-100y",
            endDate: "-18y",
            startView: 2,
            language: "fr",
            autoclose: true
        });
    </script>

    <script>

            var autocomplete;

            function initialize() {
                var options = { types: ['(cities)'] , componentRestrictions: {country: 'dz'}};
                autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')), options);
                google.maps.event.addListener(autocomplete, 'place_changed', function() {fillInAddress();});

            }

            function fillInAddress() {
                var place = autocomplete.getPlace();

                document.getElementById('ville').value = '';
                document.getElementById('wilaya').value = '';
                document.getElementById('geoloc').value = '';

                if (place.geometry.location);
                document.getElementById('geoloc').value = place.geometry.location;

                for(var i=0;i<place.address_components.length; i++){
                    if(place.address_components[i].types[0]=='locality'|| place.address_components[i].types[0]=='administrative_area3')
                    {
                        document.getElementById('ville').value = place.address_components[i].long_name;
                    }
                    if(place.address_components[i].types[0]=='administrative_area_level_1'   )
                    {
                        document.getElementById('wilaya').value = place.address_components[i].long_name;
                    }
                }
            }
        </script>

        <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
