@foreach($covoiturages as $covoiturage)
    <?php $conducteur=$covoiturage->conducteur; ?>
    <div class="vignette">
        <div class="media">
            <div class="media-left">
                <a href="{{route('user/show',$conducteur->id)}}">
                    <div class="cliquable">
                        <img class="media-object img-circle" src="{{ $path.$conducteur->pathPhoto('mini_') }}" alt="photo de profil" style="border: solid 1px #c0c1c2">
                        <div class="text-center">
                            {{ $conducteur->prenom }}<br>
                            {{ \Carbon\Carbon::createFromTimestamp(strtotime($conducteur->date_nais))->age }} ans
                        </div>
                    </div>
                </a>
            </div>
            <div class="media-body">
                <a href="{{route('covoiturage/show',$covoiturage->id)}}">
                    <div>
                        <p>
                            <h4 class="media-heading">
                               <span class="color-green glyphicon glyphicon-map-marker"></span>
                               {{ $covoiturage->villeDepart->nom }} <small>{{$covoiturage->villeDepart->wilaya}}</small>
                               <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                               <span class="color-red glyphicon glyphicon-map-marker"></span>
                               {{ $covoiturage->villeArrivee->nom }} <small>{{$covoiturage->villeArrivee->wilaya}}</small>
                            </h4>
                        </p><p>
                            <i class=" fa fa-calendar"></i>&nbsp; Départ&nbsp;
                            {{(\Carbon\Carbon::createFromTimestamp(strtotime($covoiturage->date_depart))->diffForHumans()) }}&nbsp;
                            @if($covoiturage->prix == 0)
                                <span class="label label-success">Gratuit</span>
                            @else
                                <span class="label label-primary">{{ $covoiturage->prix }} DA</span>
                            @endif
                        </p><p>
                            <i class="fa fa-car"></i> &nbsp; Vehicule : {{ $covoiturage->vehicule }}
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
 @endforeach