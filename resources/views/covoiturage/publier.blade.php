@extends('app')

@section('activePublier')
class="active"
@endsection

@section('content')
<link href="{{ asset('DateTimePicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">

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

					<form class="form-horizontal" role="form" method="POST" action="{{ route('covoiturage/store') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="panel panel-default">
                        	<div class="panel-heading"><h4><span class="glyphicon glyphicon-road"></span> Itinéraire </h4></div>
                        	<div class="panel-body">
                        		<div class="form-group">
                            		<div class="input-group col-md-offset-2 col-md-8">
                                        <span class="input-group-addon">Point de départ</span>
                                        <input name="autocomplete_d" id="autocomplete_d" type="text" class="form-control" value="{{ old('autocomplete_d') }}" required>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                                    </div>
                            	</div>
                            	<input type="hidden"  id="ville_d" name="ville_d" value="{{ old('ville_d') }}">
                                <input type="hidden"  id="wilaya_d" name="wilaya_d" value="{{ old('wilaya_d') }}">
                                <input type="hidden"  id="geoloc_d" name="geoloc_d" value="{{ old('geoloc_d') }}">

                            	<div class="form-group">
                            		<div class="input-group col-md-offset-2 col-md-8">
                                        <span class="input-group-addon">Point d'arrivée &nbsp;</span>
                                        <input name="autocomplete_a" id="autocomplete_a" type="text" class="form-control" value="{{ old('autocomplete_a') }}" required>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
                                    </div>
                            	</div>
                            	<input type="hidden"  id="ville_a" name="ville_a" value="{{ old('ville_a') }}">
                                <input type="hidden"  id="wilaya_a" name="wilaya_a" value="{{ old('wilaya_a') }}">
                                <input type="hidden"  id="geoloc_a" name="geoloc_a" value="{{ old('geoloc_a') }}">

                                <div class="form-group">
                                    <div class="input-group date col-md-offset-2 col-md-8" id="form_datetime">
                                        <span class="input-group-addon">Date et horaire &nbsp;</span>
                                        <input class="form-control" type="text" name="date_depart" value="{{ old('date_depart') }}" required readonly>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><h4><span class="glyphicon glyphicon-pencil"></span> Détails </h4></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Prix par passager</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                              <input type="text" class="form-control" name="prix" value="{{ old('prix') }}" required>
                                              <span class="input-group-addon">DZD</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-4 control-label">Nombre de places</label>
                                       <div class="col-md-6">
                                           <input type="text" class="form-control" name="nombre_places" value="{{ old('nombre_places') }}" pattern="^[0-9]+$">
                                       </div>
                                    </div>

                                    <div class="form-group">
                                       <label class="col-md-4 control-label">Votre véhicule</label>
                                       <div class="col-md-6">
                                           <input type="text" class="form-control" name="vehicule" value="{{ old('vehicule') }}" required>
                                       </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Bagages autorisés</label>
                                        <div class="col-md-6">
                                            <div class="btn-group" data-toggle="buttons">
                                              <label class="btn btn-default">
                                                <input type="radio" name="bagage" value="petit"> Petits
                                              </label>
                                              <label class="btn btn-default active">
                                                <input type="radio" name="bagage" value="moyen" checked> Moyens
                                              </label>
                                              <label class="btn btn-default">
                                                <input type="radio" name="bagage" value="grand"> Grands
                                              </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Fléxibilité Horaire</label>
                                        <div class="col-md-6">
                                            <SELECT name="flexibilite_horaire" data-toggle="select" class="form-control select select-default">
                                               <OPTION VALUE="Pile à l'heure">Pile à l'heure</OPTION>
                                               <OPTION VALUE="+/- 15 minutes">+/- 15 minutes </OPTION>
                                               <OPTION VALUE="+/- 30 minutes">+/- 30 minutes</OPTION>
                                             </SELECT>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><h4><span class="glyphicon glyphicon-list-alt"></span> Description </h4></div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Veuillez ajouter plus de détails sur votre trajet. Cela vous évitera beaucoup de questions de vos passagers.</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="details" rows="6" style="resize: none" >{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                	<div class="col-md-6 col-md-offset-4">
                                		<button type="submit" class="btn btn-primary">
                                			Publier
                                		</button>
                                	</div>
                                </div>
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

@section('script_maps_autocomplete')
    <script type="text/javascript" src="{{ asset('DateTimePicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('DateTimePicker/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>

	<script>
	var now = new Date();
	var yyyy   = now.getFullYear().toString();
	var yyyyend   = (now.getFullYear()+1).toString();
    var mm     = (now.getMonth()+1).toString();
    var dd     = now.getDate().toString();
    var hh     = ((now.getHours()+2)%24).toString();
    var ii     = now.getMinutes().toString();
    if((now.getHours()+2)>=24){dd++}
    $('#form_datetime').datetimepicker({
            language:  'fr',
            format: 'yyyy-mm-dd hh:ii',
            weekStart: 7,
            todayBtn:  1,
            autoclose: true,
            startDate: yyyy+"-"+mm+"-"+dd+" "+hh+":"+ii,
            endDate: yyyyend+"-"+mm+"-"+dd+" "+hh+":"+ii,
            minuteStep: 30
        });
    </script>

    <script src="{{asset('js/maps_autocomplete.js')}}"></script>
@endsection