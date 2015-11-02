@extends('app')

@section('activeAccueil')
class="active"
@endsection

@section('content')
<div style="  margin-bottom: 20px;">
@include('covoiturage.recherche')
</div>

<div class="container">
	<div class="row">
	    <div class="col-md-12">
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

            @if (Session::has('message'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>{!! Session::get('message') !!}</h4>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
            	<div class="panel-heading"><h5>Votre profil
                    <div class="pull-right"><a href="{{route('user/edit')}}">Modifier
                    <i class="fa fa-pencil-square-o"></i></a></div>
                    </h5>
                </div>
                <div class="panel-body">
                   <div class="col-xs-4">
                        <a href="{{ route('user/show',$user->id) }}">
                            <div class="thumbnail">
                                <img class="img-rounded" src="{{$user->pathPhoto()}}" alt="photo de profil">
                            </div>
                        </a>
                   </div>
                   <div class="col-xs-8">
                       <a href="{{ route('user/show',$user->id) }}">
                           <h3>{{$user->nom.' '.$user->prenom}}<br>
                                <small> {{$user->genre}}<br>
                                ({{ \Carbon\Carbon::createFromTimestamp(strtotime($user->date_nais))->age.' ans' }})
                                </small>
                           </h3>
                       </a>
                        <table>
                           <tr>
                              <td><h5>Ville:</h5></td>
                              <td><h5>{{$user->ville->nom}}</h5></td>
                           </tr>
                           <tr>
                             <td>
                                 <h5>
                                    Mes préférences:&nbsp;&nbsp;
                                 </h5>
                             </td>
                             <td>
                                @if($user->pref_musique=='1')
                                    <span class="label label-success"><i class="fa fa-music"></i></span></h5>
                                @else
                                    <span class="label label-default"><i class="fa fa-music"></i></span>
                                @endif
                                @if ($user->pref_animeaux==1)
                                    <span class="label label-success"><i class="fa fa-paw"></i></span>
                                @else
                                     <span class="label label-default"><i class="fa fa-paw"></i></span>
                                @endif
                                @if ($user->pref_discussion==1)
                                     <span class="label label-success"><i class="fa fa-comments"></i></span>
                                @else
                                    <span class="label label-default"><i class="fa fa-comments"></i></span>
                                @endif
                                @if ($user->pref_fumeur==1)
                                    <span class="label label-success"><i class="fa fa-magic"></i></span>
                                @else
                                    <span class="label label-default"><i class="fa fa-magic"></i></span>
                                @endif
                             </td>
                           </tr>
                        </table>
                   </div>
                </div>
                <div class="panel-body">
                   <div class="jumbotron" id="jumb">
                       <h4>Ma bio</h4>
                       <p id="text_jump">
                            @if(!empty($user->description))
                            {{$user->description}}
                            @else
                            Vous n'avez renseigné aucune description
                            @endif
                       </p>
                   </div>
                </div>
                </div>
            </div>

        <div class="col-md-6">
            <div class="panel panel-default">
            	<div class="panel-heading"><h5>Ca se passe près de chez vous !</h5></div>
            	<div class="panel-body">
                    <?php $covoiturages = $pasLoins; $path = '';?>
                    @include('covoiturage.vignette', compact('covoiturages','path'))
            	</div>
            </div>
        </div>
    </div>

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
<!--
<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES * * */
            var disqus_shortname = 'covoiturages';
            var disqus_config=function(){this.language="fr";};

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
    </div>
</div>
-->
@endsection
