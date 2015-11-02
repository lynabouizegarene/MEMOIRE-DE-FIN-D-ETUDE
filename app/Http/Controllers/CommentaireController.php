<?php namespace App\Http\Controllers;

use App\Model\Commentaire;
use App\Model\Covoiturage;
use App\Model\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller {

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
   * @return Response
   */
  public function store(Request $request)
  {
    $this->validate($request,[
        'covoiturage_id'=>'required|numeric',
        'contenu'=>'required'
    ]);

    $data=$request->all();
    $cov=Covoiturage::findOrFail($data['covoiturage_id']);

    Commentaire::create([
        'contenu'=>$data['contenu'],
        'user_id'=>Auth::User()->id,
        'covoiturage_id'=>$cov->id
    ]);

    if(Auth::User()->id != $cov->conducteur->id)
    {
        Notification::create([
            'contenu'=>Auth::User()->prenom.' a répondu à votre commentaire',
            'user_id'=>$cov->conducteur->id,
            'url' => route('covoiturage/show',$cov->id),
            'vu' => 0
        ]);
    }

    $commentaires=$cov->commentaires()->lists('user_id');
    $commentateurs=array_unique($commentaires);

    foreach($commentateurs as $commentateur)
    {
        if((Auth::User()->id != $commentateur)and($commentateur != $cov->conducteur->id))
        {
            Notification::create([
                'contenu'=>Auth::User()->prenom.' a répondu à votre commentaire',
                'user_id'=>$commentateur,
                'url' => route('covoiturage/show',$cov->id),
                'vu' => 0
            ]);
        }
    }
    return redirect()->back();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
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

?>