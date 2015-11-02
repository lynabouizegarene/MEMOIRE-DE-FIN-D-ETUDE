<?php namespace App\Http\Controllers;


use App\Http\Requests\SearchCovoiturageRequest;
use App\Http\Requests\StoreCovoiturageRequest;
use App\Model\Covoiturage;
use App\Model\Notification;
use App\Model\User;
use App\Model\Ville;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CovoiturageController extends Controller
{

    public function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::User();

        $annonces_futur = $user->conducteurCovoiturages()->with('inscrits','preinscrits','conducteur','villeDepart','villeArrivee')
            ->where('date_depart','>',date("Y-m-d H:i:s"))
            ->orderBy('date_depart')->get();

        $historique_annonces = $user->conducteurCovoiturages()->with('inscrits','preinscrits','conducteur','villeDepart','villeArrivee')
            ->where('date_depart','<',date("Y-m-d H:i:s"))
            ->orderBy('date_depart','desc')->get();

        $reservations_confirmees = $user->inscriptions()->with('inscrits','preinscrits','conducteur','villeDepart','villeArrivee')
            ->where('date_depart','>',date("Y-m-d H:i:s"))
            ->orderBy('date_depart')->get();

        $reservations = $user->preinscriptions()->with('inscrits','preinscrits','conducteur','villeDepart','villeArrivee')
            ->where('date_depart','>',date("Y-m-d H:i:s"))
            ->orderBy('date_depart')->get();

        $historique_reservations = $user->inscriptions()->with('inscrits','preinscrits','conducteur','villeDepart','villeArrivee')
            ->where('date_depart','<',date("Y-m-d H:i:s"))
            ->orderBy('date_depart','desc')->get();

        return view('covoiturage.mesCovoiturages')->with(compact('annonces_futur','historique_annonces','reservations_confirmees','reservations','historique_reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('covoiturage.publier');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCovoiturageRequest $request
     * @return Response
     */
    public function store(StoreCovoiturageRequest $request)
    {
        $data = $request->all();

        $geoloc_d = $this->getLonLat($data['geoloc_d']);
        $geoloc_a = $this->getLonLat($data['geoloc_a']);

        $ville_d = Ville::firstOrCreate([
            'nom' => $data['ville_d'],
            'wilaya' => $data['wilaya_d'],
            'longitude' => $geoloc_d[0],
            'latitude' => $geoloc_d[1],
        ]);
        $ville_a  = Ville::firstOrCreate([
            'nom' => $data['ville_a'],
            'wilaya' => $data['wilaya_a'],
            'longitude' => $geoloc_a[0],
            'latitude' => $geoloc_a[1],
        ]);

        Covoiturage::create([
            'ville_depart_id' => $ville_d->getAttribute('id'),
            'ville_arrivee_id' => $ville_a->getAttribute('id'),
            'conducteur_id' => Auth::id(),
            'nombre_places' => $data['nombre_places'],
            'date_depart' => $data['date_depart'],
            'vehicule' => $data['vehicule'],
            'prix' => $data['prix'],
            'details' => $data['details'],
            'bagage' => $data['bagage'],
            'flexibilite_horaire' => $data['flexibilite_horaire']
        ]);
        return redirect(route('home'))->with('message', 'Votre annonce a bien été publié');
    }

    /**
     * Search the specified resource.
     * @param SearchCovoiturageRequest $request
     * @return Response
     */
    public function search(SearchCovoiturageRequest $request)
    {
        $data = $request->all();

        $geoloc_d = $this->getLonLat($data['geoloc_d']);
        $geoloc_a = $this->getLonLat($data['geoloc_a']);
        $date = $data['date_depart'];

        $ville_d = Ville::firstOrNew([
            'nom' => $data['ville_d'],
            'wilaya' => $data['wilaya_d'],
            'longitude' => $geoloc_d[0],
            'latitude' => $geoloc_d[1],
        ]);
        $ville_a = Ville::firstOrNew([
            'nom' => $data['ville_a'],
            'wilaya' => $data['wilaya_a'],
            'longitude' => $geoloc_a[0],
            'latitude' => $geoloc_a[1],
            ]);
        $covoiturages = $this->searchResults($ville_d,$ville_a,$date);

        return view('covoiturage.resultatsDeRecherche')->with(compact('covoiturages','ville_d','ville_a','date'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $covoiturage =Covoiturage::with('commentaires','inscrits')->findOrFail($id);
        $user = $covoiturage->conducteur;
        $auth = Auth::User();

        $acces_tel =false;

        $user->inscriptions->each(function($inscription) use (&$acces_tel){
            //inscrits au même covoiturage
            if($inscription->inscrits->contains(Auth::User())){
                $acces_tel=true;
            }
            //je suis le conducteur
            if($inscription->conducteur->id == Auth::User()->id){
                $acces_tel=true;
            }
        });
        // il est le conducteur
        $user->conducteurCovoiturages->each(function($covoiturage) use (&$acces_tel){
            if($covoiturage->inscrits->contains(Auth::User())){
                $acces_tel=true;
            }
        });

        return view('covoiturage.details')->with(compact('covoiturage','auth','acces_tel'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $covoiturage = Covoiturage::findOrFail($request->only('covoiturage_id'))->first();

        if ($covoiturage->conducteur->id == Auth::User()->id) {
            $covoiturage->inscrits->each(function($inscrit) use (&$covoiturage)
            {
                Notification::create([
                    'contenu' => 'Attention, ' . Auth::User()->prenom . ' a supprimé le covoiturage '.$covoiturage->villeDepart->nom.' '.$covoiturage->villeArrivee->nom,
                    'user_id' => $inscrit->id,
                    'url' => route('user/show', Auth::User()->id),
                    'vu' => 0
                ]);
            });
            $covoiturage->preinscrits->each(function($preinscrit) use (&$covoiturage)
            {
                Notification::create([
                    'contenu' => 'Attention, ' . Auth::User()->prenom . ' a supprimé le covoiturage '.$covoiturage->villeDepart->nom.' '.$covoiturage->villeArrivee->nom,
                    'user_id' => $preinscrit->id,
                    'url' => route('user/show', Auth::User()->id),
                    'vu' => 0
                ]);
            });
            $covoiturage->delete();
            return redirect()->back()->with('message', 'Votre covoiturage est supprimé');
        } else {
            abort(404);
        }
    }

    public function register(){
        $covoiturage=Covoiturage::findOrFail(Input::get('coivoiturage_id'));
        $user = Auth::User();

        if($covoiturage->conducteur->id == $user->id) {
            return redirect()->back()->with('erreur','Vous êtes le conducteur');
        }elseif(Carbon::createFromTimestamp(strtotime($covoiturage->date_depart))->isPast()){
            return redirect()->back()->with('erreur','Ce covoiturage est passé');
        }elseif($covoiturage->preinscrits()->find($user->id) or $covoiturage->inscrits()->find($user->id)){
            return redirect()->back()->with('erreur','Vous êtes déjà inscrit');
        }elseif($covoiturage->nombre_places == 0){
            return redirect()->back()->with('erreur','Ce trajet est complet');
        }else{
            $covoiturage->preinscrits()->attach($user);
            Notification::create([
                'contenu'=>$user->prenom.' vient de s\'inscrire à votre covoiturage',
                'user_id'=>$covoiturage->conducteur->id,
                'url' => route('covoiturage/index'),
                'vu' => 0
            ]);
            return redirect(route('home'))->with('message','Vous êtes inscrit au covoiturage '
                .'<a href="'.route('covoiturage/show',$covoiturage->id).'">'
                .$covoiturage->villeDepart->nom
                .' <span class="glyphicon glyphicon-chevron-right text-success"></span> '
                .$covoiturage->villeArrivee->nom
                .'</a><br>'
                .'<small> vous aurez accès au coordonées de l\'annonceur après confirmation de votre réservation</small>');
        }
    }

    public function cancel(Request $request){
        $covoiturage = Covoiturage::findOrFail($request->only('covoiturage_id'))->first();

        if($covoiturage->inscrits->contains(Auth::User()) ){
            $covoiturage->inscrits()->detach(Auth::User());
            $covoiturage->increment('nombre_places');
            Notification::create([
                'contenu'=>'Attention, '.Auth::User()->prenom.' a annulé son inscription',
                'user_id'=>$covoiturage->conducteur->id,
                'url' => route('user/show',Auth::User()->id),
                'vu' => 0
            ]);
            return redirect()->back()->with('message','Votre réservation est annulée');
        }
        else{
            abort(404);
        }
    }

    public function cancel_reservation(Request $request){
        $covoiturage = Covoiturage::findOrFail($request->only('covoiturage_id'))->first();
        if($covoiturage->preinscrits->contains(Auth::User())){
            $covoiturage->preinscrits()->detach(Auth::User());
            return redirect()->back()->with('message','Votre réservation est annulée');
        }
        else{
            abort(404);
        }

    }

    public function refuse(Request $request){
        if ($request->ajax())
        {
            $data = $request->all();
            $validator = Validator::make($data,
                [
                    'annonce_id' => 'required|numeric',
                    'preinscrit_id' => 'required|numeric',
                ]);
            if ($validator->failed())
            {
                // The given data did not pass validation
                return response('Unauthorized.', 401);
            }
            else
            {
                $annonce = Covoiturage::findOrFail($data['annonce_id']);
                $preinscrit = User::findOrFail($data['preinscrit_id']);
                if
                (
                    ($annonce->isPast()) or                             //covoiturage passé
                    ($annonce->conducteur->id != Auth::User()->id) or   //je suis pas le conducteur
                    (!$annonce->preinscrits->contains($preinscrit))     //le membre n'est pas preinscrit
                )
                {
                    return response('Unauthorized.', 401);
                }
                else
                {
                    $annonce->preinscrits()->detach($preinscrit);
                    //notification
                    Notification::create([
                        'contenu'=>'Désolé, '.$annonce->conducteur->prenom.' a refusé votre inscription',
                        'user_id'=>$preinscrit->id,
                        'url' => route('covoiturage/show',$annonce->id),
                        'vu' => 0
                    ]);
                }
            }
        }

    }

    public function accept(Request $request){
        if ($request->ajax())
        {
            $data = $request->all();
            $validator = Validator::make($data,
                [
                    'annonce_id' => 'required|numeric',
                    'preinscrit_id' => 'required|numeric',
                ]);
            if ($validator->failed())
            {
                // The given data did not pass validation
                return response('Unauthorized.', 401);
            }
            else
            {
                $annonce = Covoiturage::findOrFail($data['annonce_id']);
                $preinscrit = User::findOrFail($data['preinscrit_id']);
                if(
                    ($annonce->isPast()) or                             //covoiturage passé
                    ($annonce->nombre_places == 0) or                   //plus de place
                    ($annonce->inscrits->contains($preinscrit)) or      //deja inscrit
                    ($annonce->conducteur->id != Auth::User()->id) or   //je suis pas le conducteur du covoiturage
                    (!$annonce->preinscrits->contains($preinscrit)) or  //le membre n'est pas preinscrit
                    ($preinscrit->id == Auth::User()->id)               //je suis iscrit a mon propre covoiturage
                )
                {
                    return response('Unauthorized.', 401);
                }
                else
                {
                    $annonce->preinscrits()->detach($preinscrit);
                    $annonce->inscrits()->attach($preinscrit);
                    $annonce->decrement('nombre_places');
                    //notification et mail
                    Notification::create([
                        'contenu'=>'Félicitation, '.$annonce->conducteur->prenom.' a accepté votre inscription ',
                        'user_id'=>$preinscrit->id,
                        'url' => route('covoiturage/show',$annonce->id),
                        'vu' => 0
                    ]);
                }
            }
        }


    }
}