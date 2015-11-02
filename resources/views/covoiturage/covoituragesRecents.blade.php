@extends('app')

@section('activeRecents')
class="active"
@endsection

@section('content')
<div class="container">
    <div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"><h5>Les dernières annonces de covoiturage</h5></div>
				<div class="panel-body">
                    <?php $covoiturages = $recents; $path = '../'; ?>
                    @include('covoiturage.vignette', compact('covoiturages','path'))
			    </div>
		    </div>
    </div>
</div>
@endsection