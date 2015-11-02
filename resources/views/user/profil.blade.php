@extends('app')

@section('content')

<div class="container">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                Activité
                </div>
            </div>
            <div class="panel-body">
                <ul style="list-style-type: none; padding-left: 0px">
                    <li>
                        <i class="fa fa-calendar color-blue"></i>&nbsp;
                        Date d'inscription :<br>
                        <div style="padding-left: 20px;padding-bottom: 10px"> {{\Carbon\Carbon::createFromTimestamp(strtotime($user->created_at))->diffForHumans()}}</div>
                    </li>
                    <li>
                       <span class="glyphicon glyphicon-time color-blue"></span>&nbsp;
                        Dernière connexion :<br>
                        <div style="padding-left: 20px;padding-bottom: 10px"> {{\Carbon\Carbon::createFromTimestamp(strtotime($user->updated_at))->diffForHumans()}}</div>
                    </li>
                    @if($user->moyenneAvis())
                    <li>
                        <i class="fa fa-star color-blue"></i>&nbsp;
                        Moyenne des avis:<br>
                        <div style="padding-left: 20px;padding-bottom: 10px">
                        {{$user->moyenneAvis()['moyenne']}}
                        sur {{$user->moyenneAvis()['nb_note']}} avis
                        </div>
                    </li>
                    @endif
                    <li>
                        <span class="glyphicon glyphicon-bullhorn color-blue"></span>&nbsp;
                        Annonces publiées :
                        {{$user->conducteurCovoiturages->count()}}
                    </li>
                </ul>
                <button class="btn btn-primary btn-group-justified" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                   Numéro de téléphone
                   <span class="glyphicon glyphicon-earphone"></span>
                </button>
                <div class="collapse" id="collapseExample">
                <br>
                       @if($acces_tel  or ($user->id==\Illuminate\Support\Facades\Auth::User()->id))
                               <div class="text-center alert alert-info">
                               {{$user->num_tel}}
                               </div>
                       @else
                           <div class="alert alert-danger">
                               Vous n'avez pas accès au numéro de téléphone de {{$user->prenom}}
                           </div>
                       @endif
                </div>
            </div>
        </div>
        @if($user->notesRecu->count()>0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">
                Avis sur {{$user->prenom}}
                </div>
            </div>
            <div class="panel-body">
                @foreach($notesrecu as $noterecu)
                <div class="media">
                  <div class="media-left">
                    <a href="{{route('user/show',$noterecu->noteur->id)}}">
                      <div class="thumbnail"><img class="media-object" src="{{'../'.$noterecu->noteur->pathPhoto('mini_')}}" alt="..."></div>
                    </a>
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">
                        @if($noterecu->note==5)
                        <strong class="text-primary">Extraordinaire!</strong>
                        @elseif($noterecu->note ==4)
                        <strong class="text-success" >Excellent!</strong>
                        @elseif($noterecu->note ==3)
                        <strong style="color: #75b412">Bien</strong>
                        @elseif($noterecu->note ==2)
                        <strong class="text-warning">Décevant</strong>
                        @elseif($noterecu->note ==1)
                        <strong class="text-danger">A éviter!</strong>
                        @endif
                        <br>
                    <small> De <strong>{{$noterecu->noteur->prenom.' '.$noterecu->noteur->nom[0]}}</strong></small></h4>
                    {{$noterecu->avis}}
                  </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                   <div class="col-xs-4">
                        <div class="thumbnail">
                            <img class="img-rounded" src="{{'../'.$user->pathPhoto()}}" alt="photo de profil">
                       </div>
                   </div>
                   <div class="col-xs-8">
                       <h3>{{$user->prenom.' '.$user->nom}}<br>
                            <small> {{$user->genre}}<br>
                            ({{ \Carbon\Carbon::createFromTimestamp(strtotime($user->date_nais))->age.' ans' }})
                            </small>
                       </h3>
                        <table>

                           <tr>

                              <td><h4>Ville:</h4></td>
                              <td><h4>{{$user->ville->nom}}</h4></td>

                           </tr>
                           <tr>
                               <td>
                                   <h4>
                                      préférences:&nbsp;
                                   </h4>
                               </td>
                               <td>
                                  @if($user->pref_musique=='1')
                                      <span class="label label-success"><i class="fa fa-music"></i> Musique</span>
                                  @else
                                      <span class="label label-default"><i class="fa fa-music"></i> Musique</span>
                                  @endif
                                  @if ($user->pref_animeaux==1)
                                      <span class="label label-success"><i class="fa fa-paw"></i> Animeaux</span>
                                  @else
                                      <span class="label label-default"><i class="fa fa-paw"></i> Animeaux</span>
                                  @endif
                                  @if ($user->pref_discussion==1)
                                      <span class="label label-success"><i class="fa fa-comments"></i> Discussion</span>
                                  @else
                                      <span class="label label-default"><i class="fa fa-comments"></i> Discussion</span>
                                  @endif
                                  @if ($user->pref_fumeur==1)
                                      <span class="label label-success"><i class="fa fa-magic"></i> Fumeur</span>
                                  @else
                                      <span class="label label-default"><i class="fa fa-magic"></i> Fumeur</span>
                                  @endif
                               </td>
                           </tr>

                       </table>
                   </div>
                </div>
            <div class="panel-body">
                <div class="jumbotron" id="jumb">
                    <p id="text_jump">
                         @if(!empty($user->description))
                         {{$user->description}}
                         @else
                         {{ $user->prenom }} n'a renseigné aucune description
                         @endif
                    </p>
                </div>
            </div>
        </div>
        @if( $acces_avis )
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4>
                   Laissez un avis sur {{$user->prenom}}
                </h4>
            </div>
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
                <form role="form" method="POST" action="{{ route('note/store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label class="control-label">Votre avis </label>
                        <select name="note" data-toggle="select" class="form-control select select-inverse">
                           <OPTION VALUE="5" @if($note==5) SELECTED @endif >Extraordinaire</OPTION>
                           <OPTION VALUE="4" @if($note==4) SELECTED @endif >Excellent</OPTION>
                           <OPTION VALUE="3" @if($note==3) SELECTED @endif >Bien</OPTION>
                           <OPTION VALUE="2" @if($note==2) SELECTED @endif >Décevant</OPTION>
                           <OPTION VALUE="1" @if($note==1) SELECTED @endif >A éviter</OPTION>
                        </SELECT>
                    </div>
                    <div class="form-group">
                        <label for="InputC">Comment trouvez-vous la conduite de {{$user->prenom}}</label>
                        <textarea class="form-control" id="InputC" rows="5" style="resize: none" name="avis">{{ $avis }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Envoyer</button>
                </form>
            </div>
    </div>
    @endif
</div>
</div>

@endsection