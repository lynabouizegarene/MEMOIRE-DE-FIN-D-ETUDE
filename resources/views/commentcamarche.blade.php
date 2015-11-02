@extends('app')

@section('activeCcm')
class="active"
@endsection

@section('content')
<div class="container">
    <div class="row" style="background-color: #ffffff; padding: 40px 40px">
        <div class="col-md-12">
            <h1 id="timeline"> Comment ça marche</h1>
                <p>C’est très simple !
                   Les conducteurs proposent leurs places libres dans leur véhicule et les passagers intéressés par le même trajet peuvent réserver leur place et n’auront plus qu’à voyager ensemble.</p>
                <p>Simple, économique et convivial, le covoiturage permet aujourd’hui à des millions de conducteurs d’effectuer d’importantes économies sur leurs déplacements, et aux passagers de voyager au meilleur prix vers des milliers de destinations !</p>
        </div>
        <div class="col-md-6">
            <h2>Vous êtes passager ?</h2>
            <ul class="timeline">
                <li>
                  <div class="timeline-badge primary"><i class="glyphicon glyphicon-search"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Cherchez votre trajet</h4>
                    </div>
                    <div class="timeline-body">
                    <p>Entrez vos villes de départ et de destination, ainsi que votre date de voyage.</p>
                    </div>
                  </div>
                </li>
                <li class="timeline-inverted">
                  <div class="timeline-badge warning"><i class="glyphicon glyphicon-user"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Choisissez votre conducteur</h4>
                    </div>
                    <div class="timeline-body">
                        <p>Choisissez parmi les conducteurs proposant des trajets qui vous conviennent. Si vous voulez des précisions sur un trajet, vous pouvez envoyer un message au conducteur.</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="timeline-badge danger"><i class="glyphicon glyphicon-pencil"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Inscrivez-vous !</h4>
                    </div>
                    <div class="timeline-body">
                        <p>Le conducteur choisi recevera une notification et traitera votre demande. Si vous êtes accépté, appelez le conducteur pour régler les derniers détails du voyage de vive voix.</p>
                    </div>
                  </div>
                </li>
                 <li class="timeline-inverted">
                   <div class="timeline-badge success"><i class="fa fa-car"></i></div>
                   <div class="timeline-panel">
                     <div class="timeline-heading">
                       <h4 class="timeline-title">Voyagez !</h4>
                     </div>
                     <div class="timeline-body">
                        <p> Rendez-vous au lieu de départ convenu, bien à l'heure. Bonne route!</p>
                     </div>
                   </div>
                 </li>
            </ul>
        </div>
        <div class="col-md-6">
        <h2> Vous êtes conducteur?</h2>
            <ul class="timeline">
                <li>
                  <div class="timeline-badge info"><i class="fa fa-plus-circle"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Publiez votre annonce</h4>
                    </div>
                    <div class="timeline-body">
                        <p>Indiquez la date et l'horaire de votre trajet, l'itinéraire et le prix par passager ainsi que les détails du voyage.</p>
                    </div>
                  </div>
                </li>
                <li class="timeline-inverted">
                  <div class="timeline-badge default"><i class="glyphicon glyphicon-wrench"></i></div>
                  <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Gérez les participants</h4>
                    </div>
                    <div class="timeline-body">
                        Vous pouvez accepter ou refuser des voyageurs qui s'inscriront à votre annonce selon leurs profil et préférences.
                    </div>
                  </div>
                </li>
                <li>
                   <div class="timeline-badge success"><i class="fa fa-car"></i></div>
                    <div class="timeline-panel">
                    <div class="timeline-heading">
                      <h4 class="timeline-title">Voyagez !</h4>
                    </div>
                    <div class="timeline-body">
                        <p>Rendez-vous au lieu de départ convenu, bien à l'heure. Recevez votre argent et roulez prudemment</p>
                    </div>
                  </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection