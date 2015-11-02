<style>
body {
    padding-top: 50px;
    }
</style>
<link href="{{ asset('css/bootstrap-datepicker3.standalone.min.css')}}" rel="stylesheet">

<div class="container-fluid header">
    <div class="container">
        <div class="row">
            <form role="form" method="POST" action="{{ route('covoiturage/search') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="jumbotron header">
                </div>
                    <div class="row recherche">
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">Départ</span>
                                <input name="autocomplete_d" id="autocomplete_d" type="text" class="form-control" value="{{ old('autocomplete_d') }}" required>
                                <span class="input-group-addon"><span class="color-green glyphicon glyphicon-map-marker"></span></span>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">Arrivée</span>
                                <input name="autocomplete_a" id="autocomplete_a" type="text" class="form-control" value="{{ old('autocomplete_a') }}" required>
                                <span class="input-group-addon"><span class="color-red glyphicon glyphicon-map-marker"></span></span>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa color-blue fa-calendar fa-lg"></i></span>
                                <input type="text" id="datepicker" name="date_depart" class="form-control" placeholder="Date de départ" value="{{ old('date_depart') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                <input type="hidden"  id="ville_d" name="ville_d" value="{{ old('ville_d') }}">
                <input type="hidden"  id="wilaya_d" name="wilaya_d" value="{{ old('wilaya_d') }}">
                <input type="hidden"  id="geoloc_d" name="geoloc_d" value="{{ old('geoloc_d') }}">

                <input type="hidden"  id="ville_a" name="ville_a" value="{{ old('ville_a') }}">
                <input type="hidden"  id="wilaya_a" name="wilaya_a" value="{{ old('wilaya_a') }}">
                <input type="hidden"  id="geoloc_a" name="geoloc_a" value="{{ old('geoloc_a') }}">

            </form>
        </div>
    </div>
</div>

@section('maps_onload')
    onload="initialize()"
@endsection

@section('maps_script')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places&language=fr&region=dz"></script>
@endsection

@section('script_maps_autocomplete')
        <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('locales/bootstrap-datepicker.fr-CH.min.js')}}"></script>
    	<script>
            $('#datepicker').datepicker({
                format: "yyyy-mm-dd",
                weekStart: 7,
                startDate: "now",
                todayBtn: "linked",
                language: "fr",
                orientation: "top auto"
            });
        </script>
    <script src="{{asset('js/maps_autocomplete.js')}}"></script>
@endsection
