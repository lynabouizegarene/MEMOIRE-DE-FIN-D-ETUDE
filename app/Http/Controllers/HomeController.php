<?php namespace App\Http\Controllers;

use App\Model\Covoiturage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return \App\Http\Controllers\HomeController
     */
	public function __construct()
	{
        parent::__construct();
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $recents = Covoiturage::with('villeDepart','villeArrivee','conducteur')
            ->select('id','date_depart','prix','vehicule','conducteur_id','ville_arrivee_id','ville_depart_id')
            ->where('date_depart', '>', date("Y-m-d H:i:s"))
            ->orderBy('date_depart')
            ->take(5)
            ->get();

        $bonplans = Covoiturage::with('villeDepart','villeArrivee','conducteur')
            ->select('id','date_depart','prix','vehicule','conducteur_id','ville_arrivee_id','ville_depart_id')
            ->where('prix','=','0')
            ->where('date_depart', '>', date("Y-m-d H:i:s"))
            ->orderBy('date_depart')
            ->take(5)
            ->get();

        $pasLoins = $this->covoituragesMoinDe(100,Auth::User()->ville,3);

        $user=Auth::User();

        return view('home')->with(compact('recents','bonplans','pasLoins','user'));
	}

}
