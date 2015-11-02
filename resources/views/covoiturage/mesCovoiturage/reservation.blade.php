<div class="row">

    <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Mes Réservation</h3>
          </div>
          <div class="panel-body">
            @if(($reservations->count() + $reservations_confirmees->count()) >0)
            <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
            @foreach($reservations_confirmees as $reservation)
              <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion3" href="#collapse{{$reservation->id}}" aria-expanded="true" aria-controls="collapse{{$reservation->id}}">
                    <div class="panel-heading" role="tab" id="heading{{$reservation->id}}" style="background-color: #ffffff">
                      <h4 class="panel-title">
                            <span class="color-green glyphicon glyphicon-map-marker"></span>
                            {{ $reservation->villeDepart->nom }} <small>{{$reservation->villeDepart->wilaya}}</small>
                            <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                            <span class="color-red glyphicon glyphicon-map-marker"></span>
                            {{ $reservation->villeArrivee->nom }} <small>{{$reservation->villeArrivee->wilaya}}<br></small>
                            <small style="padding-left: 25px; color: #34495e; color: #34495e">
                                <?php $date = \Carbon\Carbon::createFromTimestamp(strtotime($reservation->date_depart))?>
                                Le {{ $date->format('d/m/Y') }} à {{ $date->format('H:i') }}
                                <a href="{{route('covoiturage/show',$reservation->id)}}" class="btn-xs btn-default pull-right"><span class="glyphicon glyphicon-plus color-blue"></span></a>
                            </small>
                            <br>
                            <div class="text-right">
                            <label class="label label-success">Confirmé</label>
                            </div>
                      </h4>
                    </div>
                </a>
                <div id="collapse{{$reservation->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$reservation->id}}">
                  <div class="panel-body">

                  <table class="table table-hover">
                      <thead><strong>Les passager de ce covoiturage</strong></thead>
                      <tbody id="{{$reservation->id}}">
                      <?php $conducteur = $reservation->conducteur ;?>
                        <tr>
                            <td>{{ $conducteur->prenom }}</td>
                            <td>{{ $conducteur->nom }}</td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($conducteur->date_nais))->age }} ans</td>
                            <td>
                              <a href="{{ route('user/show',$conducteur->id) }}" class=" btn btn-xs btn-inverse">
                                  voir le profil <span class=" glyphicon glyphicon-chevron-right"></span>
                              </a>
                              <small>(conducteur)</small>
                            </td>
                        </tr>
                          @foreach($reservation->inscrits as $inscrit)
                              <tr>
                                  <td>{{ $inscrit->prenom }}</td>
                                  <td>{{ $inscrit->nom }}</td>
                                  <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($inscrit->date_nais))->age }} ans</td>
                                  <td>
                                    @if($inscrit->id == Auth::User()->id)

                                    <!-- Button trigger modal -->
                                    <a href="#" class=" btn btn-xs btn-danger link-blanc" data-toggle="modal" data-target="#myModal{{$reservation->id}}">
                                      Annuler <span class=" glyphicon glyphicon-chevron-right"></span>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h3 class="modal-title" id="myModalLabel">
                                             <span class="color-green glyphicon glyphicon-map-marker"></span>
                                                {{ $reservation->villeDepart->nom }} <small>{{$reservation->villeDepart->wilaya}}</small>
                                                <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                                                <span class="color-red glyphicon glyphicon-map-marker"></span>
                                                {{ $reservation->villeArrivee->nom }} <small>{{$reservation->villeArrivee->wilaya}}</small>
                                            </h3>
                                          </div>

                                          <div class="modal-footer">
                                            <form role="form" method="POST" action="{{ route('covoiturage/cancel') }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="covoiturage_id" value="{{ $reservation->id }}">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    @else
                                    <a href="{{ route('user/show',$inscrit->id) }}" class=" btn btn-xs btn-primary">
                                        voir le profil <span class=" glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                    @endif
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>

                  </div>
                </div>
              </div>
            @endforeach

            @foreach($reservations as $reservation)
              <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion3" href="#collapse{{$reservation->id}}" aria-expanded="true" aria-controls="collapse{{$reservation->id}}">
                    <div class="panel-heading" role="tab" id="heading{{$reservation->id}}" style="background-color: #ffffff">
                      <h4 class="panel-title">
                            <span class="color-green glyphicon glyphicon-map-marker"></span>
                            {{ $reservation->villeDepart->nom }} <small>{{$reservation->villeDepart->wilaya}}</small>
                            <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                            <span class="color-red glyphicon glyphicon-map-marker"></span>
                            {{ $reservation->villeArrivee->nom }} <small>{{$reservation->villeArrivee->wilaya}}<br></small>
                            <small style="padding-left: 25px; color: #34495e; color: #34495e">
                                <?php $date = \Carbon\Carbon::createFromTimestamp(strtotime($reservation->date_depart))?>
                                Le {{ $date->format('d/m/Y') }} à {{ $date->format('H:i') }}
                                <a href="{{route('covoiturage/show',$reservation->id)}}" class="btn-xs btn-default pull-right"><span class="glyphicon glyphicon-plus color-blue"></span></a>
                            </small>
                            <br>
                            <div class="text-right">
                            <label class="label label-warning">En attente</label>
                            </div>
                      </h4>
                    </div>
                </a>
                <div id="collapse{{$reservation->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$reservation->id}}">
                  <div class="panel-body">

                  <table class="table table-hover">
                      <thead><strong>Les passager de ce covoiturage</strong></thead>
                      <tbody>
                          <?php $conducteur = $reservation->conducteur ;?>
                          <tr>
                              <td>{{ $conducteur->prenom }}</td>
                              <td>{{ $conducteur->nom }}</td>
                              <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($conducteur->date_nais))->age }} ans</td>
                              <td>
                                <a href="{{ route('user/show',$conducteur->id) }}" class=" btn btn-xs btn-inverse">
                                    voir le profil  <span class=" glyphicon glyphicon-chevron-right"></span>
                                </a>
                                <small>(conducteur)</small>
                              </td>
                          </tr>

                          <tr>
                              <td>{{ Auth::User()->prenom }}</td>
                              <td>{{ Auth::User()->nom }}</td>
                              <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime(Auth::User()->date_nais))->age }} ans</td>
                              <td>

                                  <!-- Button trigger modal -->
                                  <a href="#" class=" btn btn-xs btn-danger link-blanc" data-toggle="modal" data-target="#myModal{{$reservation->id}}">
                                    Annuler <span class=" glyphicon glyphicon-chevron-right"></span>
                                  </a>

                                  <!-- Modal -->
                                  <div class="modal fade" id="myModal{{$reservation->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <h3 class="modal-title" id="myModalLabel">
                                           <span class="color-green glyphicon glyphicon-map-marker"></span>
                                              {{ $reservation->villeDepart->nom }} <small>{{$reservation->villeDepart->wilaya}}</small>
                                              <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                                              <span class="color-red glyphicon glyphicon-map-marker"></span>
                                              {{ $reservation->villeArrivee->nom }} <small>{{$reservation->villeArrivee->wilaya}}</small>
                                          </h3>
                                        </div>

                                        <div class="modal-footer">
                                          <form role="form" method="POST" action="{{ route('covoiturage/cancel_reservation') }}">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="hidden" name="covoiturage_id" value="{{ $reservation->id }}">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">Save changes</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                              </td>
                          </tr>

                          @foreach($reservation->inscrits as $inscrit)
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

                  </div>
                </div>
              </div>
            @endforeach
            </div>
            @else
            <div class="alert alert-info">Aucune réservation en cour</div>
            @endif
          </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Historique de mes réservations</h3>
          </div>
          <div class="panel-body">
            @if($historique_reservations->count()>0)
            <div class="panel-group" id="accordion5" role="tablist" aria-multiselectable="true">
            @foreach($historique_reservations as $historique_reservation)
              <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion5" href="#collapse{{$historique_reservation->id}}" aria-expanded="true" aria-controls="collapse{{$historique_reservation->id}}">
                    <div class="panel-heading" role="tab" id="heading{{$historique_reservation->id}}" style="background-color: #ffffff">
                      <h4 class="panel-title">
                            <span class="color-green glyphicon glyphicon-map-marker"></span>
                            {{ $historique_reservation->villeDepart->nom }} <small>{{$historique_reservation->villeDepart->wilaya}}</small>
                            <span class="glyphicon glyphicon-chevron-right text-primary"></span>
                            <span class="color-red glyphicon glyphicon-map-marker"></span>
                            {{ $historique_reservation->villeArrivee->nom }} <small>{{$historique_reservation->villeArrivee->wilaya}}<br></small>
                            <small style="padding-left: 25px; color: #34495e; color: #34495e">
                                <?php $date = \Carbon\Carbon::createFromTimestamp(strtotime($historique_reservation->date_depart))?>
                                Le {{ $date->format('d/m/Y') }} à {{ $date->format('H:i') }}
                                <a href="{{route('covoiturage/show',$historique_reservation->id)}}" class="btn-xs btn-default pull-right"><span class="glyphicon glyphicon-plus color-blue"></span></a>
                            </small>
                      </h4>
                    </div>
                </a>
                <div id="collapse{{$historique_reservation->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$historique_reservation->id}}">
                  <div class="panel-body">

                  <table class="table table-hover">
                    <thead><strong>Le conducteur de ce covoiturage</strong></thead>
                    <?php $conducteur = $historique_reservation->conducteur ;?>
                    <tbody>
                      <tr>
                          <td>{{ $conducteur->prenom }}</td>
                          <td>{{ $conducteur->nom }}</td>
                          <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($conducteur->date_nais))->age }} ans</td>
                          <td>
                            <a href="{{ route('user/show',$conducteur->id) }}" class=" btn btn-xs btn-inverse">
                                Laisser un avis <span class=" glyphicon glyphicon-chevron-right"></span>
                            </a>
                          </td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-hover">
                      <thead><strong>Les passagers de ce covoiturage</strong></thead>
                      <tbody>
                          @foreach($historique_reservation->inscrits as $inscrit)
                              <tr>
                                  <td>{{ $inscrit->prenom }}</td>
                                  <td>{{ $inscrit->nom }}</td>
                                  <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($inscrit->date_nais))->age }} ans</td>
                                  <td>
                                    <a href="{{ route('user/show',$inscrit->id) }}" class=" btn btn-xs btn-primary">
                                        Voir le profil <span class=" glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>

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