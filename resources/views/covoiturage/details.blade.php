@extends('app')
@section('content')
    <?php $conducteur=$covoiturage->conducteur; ?>

 <div class="container">

            @if(Session::has('erreur'))
            <div class="alert alert-danger">
            {{Session::get('erreur')}}
            </div>
            @endif

      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading" style="border-bottom: 5px solid #273951">
            <h1>
              {{ $covoiturage->villeDepart->nom }} <small>{{$covoiturage->villeDepart->wilaya}}</small>
              <span class="glyphicon glyphicon-chevron-right text-primary"></span>
              {{ $covoiturage->villeArrivee->nom }} <small>{{$covoiturage->villeArrivee->wilaya}}</small>
            </h1>
          </div>
               <?php $date=\Carbon\Carbon::createFromTimestamp(strtotime($covoiturage->date_depart));?>

          <div class="panel-body" >
                <table class="table">
                   <thead>
                      <td>Départ </td>
                      <td><span class="color-green glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;{{$covoiturage->villeDepart->nom}}</td>
                   </thead>
                   <tbody>
                       <tr>
                          <td>Arrivée</td>
                          <td><span class="color-red glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;{{$covoiturage->villeArrivee->nom}}</td>
                       </tr>
                       <tr>
                          <td>Date de départ </td>
                          <td><i class=" fa fa-calendar"></i>&nbsp;&nbsp;{{$date->format('d/m/Y')}}</td>
                       </tr>
                       <tr>
                          <td>Heure </td>
                          <td> <i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{$date->format('H:i')}}</td>
                       </tr>
                       <tr>
                           <td>Distance </td>
                           <td><div id="outputDivDist"></div></td>
                       </tr>
                       <tr>
                           <td>Durée estimée </td>
                           <td><div id="outputDivTime"></div></td>
                       </tr>
                       <tr>&nbsp;</tr>
                   </tbody>
                </table>
                       <?php
                       if($covoiturage->bagage == 'petit')
                            $bag='Petite taille';
                       elseif($covoiturage->bagage=='grand')
                            $bag='Grande taille';
                       elseif($covoiturage->bagage=='moyen')
                            $bag='Moyenne taille';
                       ?>
            <div class="jumbotron" id="jum">
              <div class="row" style="padding-bottom: 15px">
              <h3>
              <div class="col-xs-8">
              <strong>Détails du voyage</strong>
              </div>
              <div class="col-xs-4">
              <strong>
                  @if($covoiturage->prix == 0)
                      <span class="label label-success">Gratuit</span>
                  @else
                      <span class="label label-primary">{{ $covoiturage->prix }} DA</span>
                  @endif
              </strong>
              </div>
              </h3>
              </div>
              <table class="table">
                  <tr>
                     <td>Véhicule </td>
                     <td> <i class="fa fa-car"></i>&nbsp;&nbsp;{{$covoiturage->vehicule}}</td>
                  </tr>
                  <tr>
                     <td>Bagages</td>
                     <td><i class="fa fa-suitcase"></i>&nbsp;&nbsp;{{$bag}}</td>
                  </tr>
                  <tr>
                     <td>Flexibilité Horaire</td>
                     <td>{{$covoiturage->flexibilite_horaire}}</td>
                  </tr>
                  <tr>
                     <td>Détails</td>
                     <td>{{$covoiturage->details}}</td>
                  </tr>
              </table>
            </div>
               <div class="text-right">
                Publier le : {{ \Carbon\Carbon::createFromTimestamp(strtotime($covoiturage->created_at))->format('d/m/Y') }}
               </div>

            <div id="map-canvas"></div>
          </div>
        </div>
        <div class="panel panel-info">
             <div class="panel-heading">
                 <h4>
                     Questions publiques ({{ $covoiturage->commentaires->count() }})
                 </h4>
             </div>
             <div class="panel-body">
                 <div style="padding-bottom: 30px">
                     @foreach($covoiturage->commentaires as $commentaire)
                         <div class="row">
                             <div class="col-xs-12" style="border-bottom: 1px solid #e7e7e7; padding-top: 10px; padding-bottom: 10px">
                             @if($commentaire->user->id != $conducteur->id)
                             <div class="media">
                                 <div class="media-left">
                                   <a href="{{route('user/show',$commentaire->user->id)}}">
                                     <div class="thumbnail">
                                     <img class="media-object" src="{{'../'.$commentaire->user->pathPhoto('mini_')}}" alt="photo profil">
                                     </div>
                                   </a>
                                 </div>
                                 <div class="media-body">
                                   <h4 class="media-heading">{{$commentaire->user->prenom.' '.$commentaire->user->nom}}
                                   <small>
                                   {{\Carbon\Carbon::createFromTimestamp(strtotime($commentaire->created_at))->diffForHumans()}}
                                   </small>
                                   </h4>
                                   {{$commentaire->contenu}}
                                 </div>
                             </div>
                              @else
                              <div class="media pull-right color-blue">
                                 <div class="media-body">
                                   <h4 class="media-heading text-right">
                                     <a href="{{route('user/show',$commentaire->user->id)}}">
                                     {{$commentaire->user->prenom.' '.$commentaire->user->nom}}
                                     </a>
                                   <small>
                                   {{\Carbon\Carbon::createFromTimestamp(strtotime($commentaire->created_at))->diffForHumans()}}
                                   </small>
                                   </h4>
                                   {{$commentaire->contenu}}
                                 </div>
                                  <div class="media-right">
                                    <a href="{{route('user/show',$commentaire->user->id)}}">
                                      <div class="thumbnail">
                                      <img class="media-object" src="{{'../'.$commentaire->user->pathPhoto('mini_')}}" alt="photo profil">
                                      </div>
                                    </a>
                                  </div>
                              </div>
                              @endif
                             </div>
                         </div>
                     @endforeach
                 </div>
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

                 <form role="form" method="POST" action="{{ route('comment/store') }}">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input type="hidden" name="covoiturage_id" value="{{$covoiturage->id}}">
                     <div class="form-group">
                         <label for="InputC"><strong>Poser vos questions au conducteur</strong></label>
                         <textarea class="form-control" id="InputC" rows="5" style="resize: none" name="contenu">{{ old('contenu') }}</textarea>
                     </div>
                     <button type="submit" class="btn btn-default">Envoyer</button>
                 </form>
             </div>
        </div>
     </div>


      <div class="col-md-4">
          <div class="panel">
          @if($covoiturage->nombre_places > 0 )
               <table>
                 <thead>
                    <div class="text-center">
                       <h2>Il reste {{$covoiturage->nombre_places}} places</h2>
                    </div>
                 </thead>
                 <tr>
                    <div class="text-center">
                      @for($i=0;$i<$covoiturage->nombre_places;$i++)
                       <span class="glyphicon glyphicon-user"></span>
                      @endfor
                    </div>
                 </tr>
                 <tr>
                   <div class="text-center">
                      <form role="form" method="POST" action="{{ route('covoiturage/register') }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="coivoiturage_id" value="{{$covoiturage->id}}">
                          <h3><button type="submit" class="btn btn-primary btn-lg"><strong>S'inscrire</strong></button></h3>
                      </form>
                   </div>
                 </tr>
               </table>
               @else
               <h3 class="text-center"> Ce trajet est complet </h3>
               @endif
          </div>
          <div class="panel panel-info">
              <div class="panel-heading">
                 <div class="panel-title">Profil du Conducteur
                 </div>
              </div>
              <div class="panel-body">
                    <div class="row">
                         <div class="col-xs-6">
                         <a href="{{route('user/show',$conducteur->id)}}">
                           <div class="thumbnail">
                               <img class="img-rounded" src="{{ '../'.$conducteur->pathPhoto() }}" alt="photo de profil">
                           </div>
                         </a>
                         </div>
                         <div class="col-xs-6">
                         <a href="{{route('user/show',$conducteur->id)}}">
                            <h4>
                             {{ $conducteur->prenom }}<br>
                             {{ $conducteur->nom }}<br>
                            </h4>
                         </a>
                             {{ $conducteur->genre }}<br>
                             {{ \Carbon\Carbon::createFromTimestamp(strtotime($conducteur->date_nais))->age }} ans<br>
                         </div>
                         <div class="col-xs-12">
                         <button class="btn btn-primary btn-group-justified" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Numéro de téléphone
                            <span class="glyphicon glyphicon-earphone"></span>
                         </button>
                         <div class="collapse" id="collapseExample">
                         <br>
                                @if($acces_tel or ($auth->id == $conducteur->id))
                                        <div class="text-center alert alert-info">
                                        {{$conducteur->num_tel}}
                                        </div>
                                @else
                                    <div class="alert alert-danger">
                                        Vous aurez accès au numéro de téléphone après confirmation de votre réservation
                                    </div>
                                @endif
                         </div>
                         <p>
                            <br>
                            <span class="glyphicon glyphicon-map-marker color-blue"></span>&nbsp;
                            Ville : {{ $conducteur->ville->nom }}<br>
                            <span class="glyphicon glyphicon-bullhorn color-blue"></span>&nbsp;
                            Annonces publiées : <span class="badge badge-primary">{{ $conducteur->conducteurCovoiturages->count() }}</span><br>
                            <span class="glyphicon glyphicon-time color-blue"></span>&nbsp;
                            Dernière connexion : {{ \Carbon\Carbon::createFromTimestamp(strtotime($conducteur->updated_at))->diffForHumans() }}<br>
                            @if($conducteur->moyenneAvis())
                                 <i class="fa fa-star color-blue"></i>&nbsp;
                                 Moyenne des avis :
                                 {{$conducteur->moyenneAvis()['moyenne']}}
                                 sur {{$conducteur->moyenneAvis()['nb_note']}} avis
                            @endif
                         </p>
                         <p>
                             Préférences de voyage : <br>
                             @if($conducteur->pref_musique == 1)
                             <span class="label label-success">Musique</span>
                             @else
                             <span class="label label-default">Musique</span>
                             @endif
                             @if($conducteur->pref_animeaux == 1)
                             <span class="label label-success">Animeaux</span>
                             @else
                             <span class="label label-default">Animeaux</span>
                             @endif
                             @if($conducteur->pref_discussion == 1)
                             <span class="label label-success">Discussion</span>
                             @else
                             <span class="label label-default">Discussion</span>
                             @endif
                             @if($conducteur->pref_fumeur == 1)
                             <span class="label label-success">Fumeur</span>
                             @else
                             <span class="label label-default">Fumeur</span>
                             @endif
                         </p>
                         </div>
                    </div>
              </div>
          </div>
    </div>
</div>

<?php
$depart = $covoiturage->villeDepart;
$arrivee = $covoiturage->villeArrivee;
?>
@include('covoiturage.script_carte', compact('depart','arrivee'))

@endsection
