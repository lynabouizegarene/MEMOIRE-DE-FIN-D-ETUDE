<?php namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Model\User;
use App\Model\Ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller {

    private $acces_tel;
    private $acces_avis;
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   *@param  StoreUserRequest $request
   * @return Response
   */
  public function store(StoreUserRequest $request)
  {
      $user=Auth::User();
      $data = $request->all();

      $geoloc = $this->getLonLat($data['geoloc']);


      $ville = Ville::firstOrCreate([
          'nom' => $data['ville'],
          'wilaya' => $data['wilaya'],
          'longitude' => $geoloc[0],
          'latitude' => $geoloc[1],
      ]);

      $user->nom=$data['nom'];
      $user->prenom=$data['prenom'];
      $user->genre=$data['genre'];
      $user->date_nais=$data['date_nais'];
      $user->num_tel=$data['num_tel'];
      $user->ville_id= $ville->id;
      $user->pref_musique=$data['pref_musique'];
      $user->pref_animeaux=$data['pref_animeaux'];
      $user->pref_discussion=$data['pref_discussion'];
      $user->pref_fumeur=$data['pref_fumeur'];
      $user->description=$data['description'];
      $user->save();

      if (Input::file('photo')) {
          $destination = '../storage/app'; // path
          $fileName = $user->getAttribute('id') . '.jpg'; // renameing image
          Input::file('photo')->move($destination, $fileName);
          // redimensionner
          $largeur = 64;
          $hauteur = 64;
          $image = imagecreatefromjpeg($destination.'/'.$fileName);
          $taille = getimagesize($destination.'/'.$fileName);

          $sortie = imagecreatetruecolor($largeur,$hauteur);
          $coef = min($taille[0]/$largeur,$taille[1]/$hauteur);

          $deltax = $taille[0]-($coef * $largeur);
          $deltay = $taille[1]-($coef * $hauteur);

          imagecopyresampled($sortie,$image,0,0,$deltax/2,$deltay/2,$largeur,$hauteur,$taille[0]-$deltax,$taille[1]-$deltay);
          imagejpeg($sortie,$destination.'/mini_'.$fileName);
      }

      return redirect(route('home'))->with('message', 'Votre profil a bien été mis à jour');

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
      $user = User::findOrFail($id);

      $this->acces_tel=false;
      $this->acces_avis=false;

      //inscrits au même covoiturage
      $user->inscriptions->each(function($inscription){
          if($inscription->inscrits->contains(Auth::User())){
              $this->acces_tel=true;
          }
      //je suis le conducteur
          if($inscription->conducteur->id == Auth::User()->id){
              $this->acces_tel=true;
          }
      });
      // il est le conducteur
      $user->conducteurCovoiturages->each(function($covoiturage){
          if($covoiturage->inscrits->contains(Auth::User())){
              $this->acces_tel=true;
              if($covoiturage->isPast()){
                  $this->acces_avis=true;
              }
          }
      });
      $acces_tel=$this->acces_tel;
      $acces_avis=$this->acces_avis;

      if($acces_avis)
      $note = $user->notesRecu->filter(function($note)
      {
          return $note->noteur_id == Auth::User()->id;
      })->first();

      if(isset($note)){
          $avis = $note->avis;
          $note = $note->note;
      }
      else{
          $avis = '';
          $note = '';
      }

      $notesrecu=$user->notesRecu()->with('noteur')->orderBy('updated_at','desc')->get()->take(8);

      return  view('user.profil')->with(compact('user','acces_tel','acces_avis','avis','note','notesrecu'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @return Response
   */
  public function edit()
  {
      return view('user.editer');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}
