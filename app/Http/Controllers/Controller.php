<?php namespace App\Http\Controllers;

use App\Model\Covoiturage;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Model\Ville;

abstract class Controller extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    public function __construct(){
        Carbon::setLocale('fr');
    }
    private $ville_d;
    private $ville_a;
    private $date;
    private function formule ($latitude,$longitude){
        return "(6366*acos(cos(radians($latitude))*cos(radians(`latitude`))*cos(radians(`longitude`) -radians($longitude))+sin(radians($latitude))*sin(radians(`latitude`))))";
    }

    protected function getLonLat($geoloc){
        $geoloc = str_replace(["(", ")"], "", $geoloc);
        $geoloc = explode(",", $geoloc);
        $geoloc[0] = (Double)($geoloc[0]);
        $geoloc[1] = (Double)($geoloc[1]);
        return $geoloc;
    }

    protected  function covoituragesMoinDe($km,Ville $v,$limit=5){

        $latitude= $v->latitude;
        $longitude=$v->longitude;

        $villes = Ville::with('departs')->select('id',DB::raw($this->formule($latitude,$longitude).' as dist'))->where(DB::raw($this->formule($latitude,$longitude)) ,'<=', $km)->orderBy('dist','desc')->get();

        $covoituages =new Collection();
        foreach($villes as $ville){
            $ville->departs->load('villeDepart','villeArrivee','conducteur');
            foreach($ville->departs as $depart){
                $covoituages->prepend($depart);
            }
        }
        $covoituages = $covoituages->filter(function($covoituage){
            return $covoituage->date_depart > date("Y-m-d H:i:s");
        });
        return $covoituages->take($limit);
    }

    protected function searchResults($ville_depart,$ville_arrivee,$date_depart){

        $this->ville_d = $ville_depart;
        $this->ville_a = $ville_arrivee;
        $this->date = $date_depart;

        $covoiturages = Covoiturage::with('villeDepart','villeArrivee','conducteur');

        if(!empty($this->date)){
            $covoiturages = $covoiturages
                ->whereBetween('date_depart', [
                    $this->date,
                    Carbon::createFromTimestamp(strtotime($this->date))->addDay()->toDateString()
                ]);
        }else{
            $covoiturages = $covoiturages->where('date_depart', '>', date("Y-m-d H:i:s"));
        }


        $covoiturages = $covoiturages
            ->whereHas('villeDepart', function($q)
                {
                    $q->where(DB::raw($this->formule($this->ville_d->latitude,$this->ville_d->longitude)) ,'<=', '50');
                }
            )->whereHas('villeArrivee', function($q)
                {
                    $q->where(DB::raw($this->formule($this->ville_a->latitude,$this->ville_a->longitude)) ,'<=', '50');
                }
            )->get();


        $covoiturages->each(function($covoiturage)
        {
            $covoiturage->dist =
            $this->distance(
                $this->ville_d->latitude,$this->ville_d->longitude,
                $covoiturage->villeDepart->latitude,$covoiturage->villeDepart->longitude)+
            $this->distance(
                $this->ville_a->latitude,$this->ville_a->longitude,
                $covoiturage->villeArrivee->latitude,$covoiturage->villeArrivee->longitude);
        });

        return $covoiturages->sortBy('dist');
    }


    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        //rayon de la terre
        $r = 6366;
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lon1 = deg2rad($lon1);
        $lon2 = deg2rad($lon2);

        //calcul précis
        $dp= 2 * asin(sqrt(pow (sin(($lat1-$lat2)/2) , 2) + cos($lat1)*cos($lat2)* pow( sin(($lon1-$lon2)/2) , 2)));

        //sortie en km
        return $dp * $r;
    }
}
