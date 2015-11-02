@extends('app')
@section('content')
@include('covoiturage.recherche')
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="{{url("../public/img/BGbluegray.jpg")}}" alt="photo1">
          <div class="carousel-caption">
          </div>
        </div>
        <div class="item">
          <img src="{{url("../public/img/BGubuntu.jpg")}}" alt="photo2">
          <div class="carousel-caption">
          </div>
        </div>
        <div class="item">
          <img src="{{url("../public/img/BGbluegray.jpg")}}" alt="photo3">
          <div class="carousel-caption">
          </div>
        </div>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Précédent</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Prochain</span>
      </a>
    </div>
    <div class="container" style="padding-top: 20px">
        <div class="row">
        	<div class="col-md-6">
        		<div class="panel panel-default">
        			<div class="panel-heading"><h5>Les dernières annonces de covoiturage</h5></div>
        			<div class="panel-body">
                        <?php $covoiturages = $recents; $path = ''; ?>
                        @include('covoiturage.vignette', compact('covoiturages','path'))
        		    </div>
        	    </div>
        	</div>
        	<div class="col-md-6">
        		<div class="panel panel-default">
        			<div class="panel-heading"><h5>Les covoiturages gratuits</h5></div>
        			<div class="panel-body">
                        <?php $covoiturages = $bonplans; $path = ''; ?>
                        @include('covoiturage.vignette', compact('covoiturages','path'))
        		    </div>
        	    </div>
        	</div>
        </div>
    </div>

@endsection
@section('script_carousel')
<script>
//$('.carousel').carousel();
$('.fade').slick({
  dots: true,
  infinite: true,
  speed: 500,
  fade: true,
  cssEase: 'linear'
});
</script>
@endsection