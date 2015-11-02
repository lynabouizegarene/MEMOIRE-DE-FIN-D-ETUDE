@extends('app')

@section('content')
<link href="{{ asset('css/bootstrap-datepicker3.standalone.min.css')}}" rel="stylesheet">

<?php
$user=Auth::user() ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Editer votre profil</h4></div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ route('user/store') }}" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="well text-center"><h4>Vos coordonnées</h4></div>

						<div class="form-group">
							<label class="col-md-4 control-label">Nom</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="nom" value="{{$user->nom}}" required>
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-4 control-label">Prenom</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="prenom" value="{{ $user->prenom }}" required>
							</div>
						</div>

                        <div class="form-group">
							<label class="col-md-4 control-label">Civilité</label>
							<div class="col-md-6">
							    <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default
                                  @if($user->genre == 'Homme')
                                  {{'active'}}
                                  @endif
                                  ">
                                    <input type="radio" name="genre" value="Homme"
                                    @if($user->genre == 'Homme')
                                    {{'checked'}}
                                    @endif
                                    > Homme
                                  </label>
                                  <label class="btn btn-default
                                    @if($user->genre == 'Femme')
                                    {{'active'}}
                                    @endif
                                  ">
                                    <input type="radio" name="genre" value="Femme"
                                    @if($user->genre == 'Femme')
                                    {{'checked'}}
                                    @endif
                                    > Femme
                                  </label>
                                </div>
                            </div>
						</div>

						<div class="form-group">
                            <label class="col-md-4 control-label">Date de naissance</label>
                        	<div class="col-md-6">
                        		<input type="text" class="form-control" id="datepicker" name="date_nais" value="{{$user->date_nais}}" required>
                        	</div>
                        </div>

                        <div class="form-group">
							<label class="col-md-4 control-label">Numéro de téléphone</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="num_tel" value="{{ $user->num_tel }}" required pattern="^0[0-9]{8,9}$">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Ville</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="autocomplete"  value="{{ $user->ville->nom }}" required>
							</div>
						</div>
                        <!-- hidden-->
                         <input type="hidden"  id="ville"  class="form-control" name="ville" value="{{ $user->ville->nom }}">
                         <input type="hidden"  id="wilaya" class="form-control" name="wilaya" value="{{ $user->ville->wilaya}}">
                         <input type="hidden"  id="geoloc" class="form-control" name="geoloc" value="{{ '('.$user->ville->longitude.','.$user->ville->latitude.')' }}">
                        <!-- hidden fin-->
                        <div class="well text-center"><h4>vos préférences de voyage</h4></div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Musique</label>
                        	<div class="col-md-6">
                                <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default
                                    @if($user->pref_musique == '1')
                                        {{'active'}}
                                    @endif">
                                    <input type="radio" name="pref_musique" value="1"
                                    @if($user->pref_musique == '1')
                                        {{'checked'}}
                                    @endif
                                    > Oui
                                  </label>
                                  <label class="btn btn-default
                                    @if($user->pref_musique == '0')
                                        {{'active'}}
                                    @endif">

                                    <input type="radio" name="pref_musique" value="0"
                                    @if($user->pref_musique == '0')
                                        {{'checked'}}
                                    @endif
                                    > Non
                                  </label>
                                </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Animaux</label>
                        	<div class="col-md-6">
                        	    <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default
                                   @if($user->pref_animeaux == '1')
                                       {{'active'}}
                                   @endif">

                                    <input type="radio" name="pref_animeaux" value="1"
                                   @if($user->pref_animeaux == '1')
                                       {{'checked'}}
                                   @endif> Oui
                                  </label>
                                  <label class="btn btn-default
                                  @if($user->pref_animeaux == '0')
                                      {{'active'}}
                                  @endif">
                                    <input type="radio" name="pref_animeaux" value="0"
                                   @if($user->pref_animeaux == '0')
                                       {{'checked'}}
                                   @endif> Non
                                  </label>
                                </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Discussion</label>
                        	<div class="col-md-6">
                        	  <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default
                                @if($user->pref_discussion == '1')
                                    {{'active'}}
                                @endif">
                                  <input type="radio" name="pref_discussion" value="1"
                                @if($user->pref_discussion == '1')
                                    {{'checked'}}
                                @endif> Oui
                                </label>
                                <label class="btn btn-default
                                @if($user->pref_discussion == '0')
                                    {{'active'}}
                                @endif">
                                  <input type="radio" name="pref_discussion" value="0"
                                @if($user->pref_discussion == '0')
                                    {{'checked'}}
                                @endif> Non
                                </label>
                              </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Fumeur</label>
                        	<div class="col-md-6">
                        	    <div class="btn-group" data-toggle="buttons">
                                  <label class="btn btn-default
                                  @if($user->pref_fumeur == '1')
                                      {{'active'}}
                                  @endif">
                                    <input type="radio" name="pref_fumeur" value="1"
                                  @if($user->pref_fumeur == '1')
                                      {{'checked'}}
                                  @endif> Oui
                                  </label>
                                  <label class="btn btn-default
                                  @if($user->pref_fumeur == '0')
                                      {{'active'}}
                                  @endif">
                                    <input type="radio" name="pref_fumeur" value="0"
                                  @if($user->pref_fumeur == '0')
                                      {{'checked'}}
                                  @endif> Non
                                  </label>
                                </div>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Présentation</label>
                        	<div class="col-md-6">
                        		<textarea class="form-control" name="description" rows="6" style="resize:none">{{ $user->description }}</textarea>
                        	</div>
                        </div>

                        <div class="form-group">
                        	<label class="col-md-4 control-label">Votre photo</label>
                            <div class="col-md-6">
                            <div class="row">
                              <div class="col-xs-12">
                                <div class="thumbnail">
                                <img src="{{ '../'.$user->pathPhoto() }}" alt="photo de profil" class="img-rounded">
                                </div>
                              </div>

                            </div>

                        	<input type="file" name="photo">
                        	</div>
                        </div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Enregistrer
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
@endsection