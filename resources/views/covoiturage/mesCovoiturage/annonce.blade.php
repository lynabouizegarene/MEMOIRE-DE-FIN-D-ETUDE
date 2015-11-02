<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Mes annonces en cours</h3>
          </div>
          <div class="panel-body">
          @if($annonces_futur->count()>0)
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($annonces_futur as $annonce_futur)
              <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$annonce_futur->id}}" aria-expanded="true" aria-controls="collapse{{$annonce_futur->id}}">
                    <div class="panel-heading" role="tab" id="heading{{$annonce_futur->id}}" style="background-color: #ffffff">
                      <h4 class="panel-title">
                            <span class="color-green glyphicon glyphicon-map-marker"></span>
                            {{ $annonce_futur->villeDepart->nom }} <small>{{$annonce_futur->villeDepart->wilaya}}</small>
                            <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                            <span class="color-red glyphicon glyphicon-map-marker"></span>
                            {{ $annonce_futur->villeArrivee->nom }} <small>{{$annonce_futur->villeArrivee->wilaya}}<br></small>
                            <small style="padding-left: 25px; color: #34495e; color: #34495e">
                                <?php $date = \Carbon\Carbon::createFromTimestamp(strtotime($annonce_futur->date_depart))?>
                                Le {{ $date->format('d/m/Y') }} à {{ $date->format('H:i') }}
                                <a href="{{route('covoiturage/show',$annonce_futur->id)}}" class="btn-xs btn-default pull-right"><span class="glyphicon glyphicon-plus color-blue"></span></a>
                            </small>
                      </h4>
                    </div>
                </a>
                <div id="collapse{{$annonce_futur->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$annonce_futur->id}}">
                  <div class="panel-body">

                  @if($annonce_futur->preinscrits->count()>0)
                  <table class="table table-hover">
                      <thead><strong>Les membres inscrits à ce covoiturage</strong></thead>
                      <tbody>
                          @foreach($annonce_futur->preinscrits as $preinscrit)
                              <tr>
                                  <td><a href="{{ route('user/show',$preinscrit->id) }}">{{ $preinscrit->prenom }}</a></td>
                                  <td><a href="{{ route('user/show',$preinscrit->id) }}">{{ $preinscrit->nom }}</a></td>
                                  <td><a href="{{ route('user/show',$preinscrit->id) }}">{{ \Carbon\Carbon::createFromTimestamp(strtotime($preinscrit->date_nais))->age }} ans</a></td>
                                  <td>
                                    <a class=" btn btn-xs btn-success" id="annonce_futur{{$annonce_futur->id}}preinscrit{{$preinscrit->id}}ok">Accepter</a>
                                    <a class=" btn btn-xs btn-danger " id="annonce_futur{{$annonce_futur->id}}preinscrit{{$preinscrit->id}}notok">Refuser</a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  @else
                    <div class="text-center alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        Aucun membre inscrit à ce covoiturage
                    </div>
                  @endif

                  @if($annonce_futur->inscrits->count()>0)
                  <table class="table table-hover">
                      <thead><strong>Les passager de ce covoiturage</strong></thead>
                      <tbody id="{{$annonce_futur->id}}">
                          @foreach($annonce_futur->inscrits as $inscrit)
                              <tr>
                                  <td>{{ $inscrit->prenom }}</td>
                                  <td>{{ $inscrit->nom }}</td>
                                  <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($inscrit->date_nais))->age }} ans</td>
                                  <td>
                                    <a href="{{ route('user/show',$inscrit->id) }}" class=" btn btn-xs btn-primary">
                                        voir le profil <span class=" glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  @else
                    <div class="text-center alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        Ce covoiturage n'a pas de passager
                    </div>
                  @endif

                  <!-- Button trigger modal -->
                  <a href="#" class=" btn btn-xs btn-danger link-blanc btn-group-justified" data-toggle="modal" data-target="#myModal{{$annonce_futur->id}}">
                    Supprimer l'annonce<span class=" glyphicon glyphicon-chevron-right"></span>
                  </a>

                  <!-- Modal -->
                  <div class="modal fade" id="myModal{{$annonce_futur->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h3 class="modal-title" id="myModalLabel">
                           <span class="color-green glyphicon glyphicon-map-marker"></span>
                              {{ $annonce_futur->villeDepart->nom }} <small>{{$annonce_futur->villeDepart->wilaya}}</small>
                              <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                              <span class="color-red glyphicon glyphicon-map-marker"></span>
                              {{ $annonce_futur->villeArrivee->nom }} <small>{{$annonce_futur->villeArrivee->wilaya}}</small>
                          </h3>
                        </div>

                        <div class="modal-footer">
                          <form role="form" method="POST" action="{{ route('covoiturage/destroy') }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="covoiturage_id" value="{{ $annonce_futur->id }}">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  </div>
                </div>
              </div>
            @endforeach
            </div>
            @else
            <div class="alert alert-info">Aucun covoiturage en cour</div>
            @endif
          </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Historique de mes annonces</h3>
          </div>
          <div class="panel-body">
            @if($historique_annonces->count()>0)
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
            @foreach($historique_annonces as $historique_annonce)
              <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion2" href="#collapse{{$historique_annonce->id}}" aria-expanded="true" aria-controls="collapse{{$historique_annonce->id}}">
                    <div class="panel-heading" role="tab" id="heading{{$historique_annonce->id}}" style="background-color: #ffffff">
                      <h4 class="panel-title">
                            <span class="color-green glyphicon glyphicon-map-marker"></span>
                            {{ $historique_annonce->villeDepart->nom }} <small>{{$historique_annonce->villeDepart->wilaya}}</small>
                            <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                            <span class="color-red glyphicon glyphicon-map-marker"></span>
                            {{ $historique_annonce->villeArrivee->nom }} <small>{{$historique_annonce->villeArrivee->wilaya}}<br></small>
                            <small style="padding-left: 25px; color: #34495e; color: #34495e">
                                <?php $date = \Carbon\Carbon::createFromTimestamp(strtotime($historique_annonce->date_depart))?>
                                Le {{ $date->format('d/m/Y') }} à {{ $date->format('H:i') }}
                                <a href="{{route('covoiturage/show',$historique_annonce->id)}}" class="btn-xs btn-default pull-right"><span class="glyphicon glyphicon-plus color-blue"></span></a>
                            </small>
                      </h4>
                    </div>
                </a>
                <div id="collapse{{$historique_annonce->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$historique_annonce->id}}">
                  <div class="panel-body">

                  @if($historique_annonce->inscrits->count()>0)
                  <table class="table table-hover">
                      <thead><strong>Les passager de ce covoiturage</strong></thead>
                      <tbody id="{{$historique_annonce->id}}">
                          @foreach($historique_annonce->inscrits as $inscrit)
                              <tr>
                                  <td>{{ $inscrit->prenom }}</td>
                                  <td>{{ $inscrit->nom }}</td>
                                  <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($inscrit->date_nais))->age }} ans</td>
                                  <td>
                                    <a href="{{ route('user/show',$inscrit->id) }}" class=" btn btn-xs btn-primary">
                                        voir le profil <span class=" glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  @else
                    <div class="text-center alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        Ce covoiturage n'a pas de passager
                    </div>
                  @endif

                  </div>
                </div>
              </div>
            @endforeach
            </div>
            @else
            <div class="alert alert-info">Aucun covoiturage dans votre historique</div>
            @endif
          </div>
        </div>
    </div>
</div>
@section('script_ajax')
<script>

@foreach($annonces_futur as $annonce_futur)
@foreach($annonce_futur->preinscrits as $preinscrit)
    $('#annonce_futur'+'{{$annonce_futur->id}}'+'preinscrit'+'{{$preinscrit->id}}'+'ok').click(function() {
        $.post('{{route('covoiturage/accept')}}',
            {
                annonce_id: '{{$annonce_futur->id}}',
                preinscrit_id: '{{$preinscrit->id}}',
                _token: '{{ csrf_token() }}'
            },
            function(){
                $('#annonce_futur'+'{{$annonce_futur->id}}'+'preinscrit'+'{{$preinscrit->id}}'+'ok').parent().parent().fadeOut("slow");
                $('#'+'{{$annonce_futur->id}}').append(
                    '<tr>' +
                     '<td>{{ $preinscrit->prenom }}</td><td>{{ $preinscrit->nom }}</td><td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($preinscrit->date_nais))->age }} ans</td><td><a href="{{ route('user/show',$preinscrit->id) }}" class=" btn btn-xs btn-primary">voir le profil <span class=" glyphicon glyphicon-chevron-right"></span></a></td>'+
                    '</tr>'
                );
                $('#'+'{{$annonce_futur->id}}'+' tr:last').hide().show("slow");
            }
        );
    });

    $('#annonce_futur'+'{{$annonce_futur->id}}'+'preinscrit'+'{{$preinscrit->id}}'+'notok').click(function() {
        $.post('{{route('covoiturage/refuse')}}',
            {
                annonce_id: '{{$annonce_futur->id}}',
                preinscrit_id: '{{$preinscrit->id}}',
                _token: '{{ csrf_token() }}'
            },
            function(){
                $('#annonce_futur'+'{{$annonce_futur->id}}'+'preinscrit'+'{{$preinscrit->id}}'+'notok').parent().parent().fadeOut("slow");
            }
        );
    });
@endforeach
@endforeach
</script>

@endsection