@extends('app')

@section('content')
<div style="  margin-bottom: 20px;">
@include('covoiturage.recherche')
</div><div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
    	<div class="panel-heading">
            <h3>
                <span class="color-green glyphicon glyphicon-map-marker"></span>
                    {{ $ville_d->nom }} <small>{{$ville_d->wilaya}}</small>
                    <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                    <span class="color-red glyphicon glyphicon-map-marker"></span>
                    {{ $ville_a->nom }} <small>{{$ville_a->wilaya}}</small>
            </h3>
        </div>
    	<div class="panel-body">
    	    <div class="text-center alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                @if($covoiturages->count() == 0)
                    Aucun résultat trouvé
                @elseif($covoiturages->count() == 1)
                    Un seul résultat trouvé
                @else
                    {{ $covoiturages->count() }} résultats trouvés
                @endif

                @if(!empty($date))
                    pour le {{ $date }}
                @endif
            </div>
    	    <?php $path = '../'?>
            @include('covoiturage.vignette', compact('covoiturages','path'))
    	</div>
    </div>
</div>
@endsection