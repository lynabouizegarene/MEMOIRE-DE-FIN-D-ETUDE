<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Covoiturage
 *
 * @property integer $id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property integer $ville_depart_id 
 * @property integer $ville_arrivee_id 
 * @property integer $conducteur_id 
 * @property string $date_depart 
 * @property string $vehicule 
 * @property integer $prix 
 * @property string $details 
 * @property string $bagage 
 * @property string $flexibilite_horaire 
 * @property integer $nombre_places
 */
class Covoiturage extends Model
{

    public $timestamps = true;
    protected $table = 'covoiturages';
    protected $guarded = array('id', 'timestamps');

    public function villeDepart()
    {
        return $this->belongsTo('App\Model\Ville', 'ville_depart_id');
    }

    public function villeArrivee()
    {
        return $this->belongsTo('App\Model\Ville', 'ville_arrivee_id');
    }

    public function inscrits()
    {
        return $this->belongsToMany('App\Model\User', 'user_covoiturage_inscrits')->withTimestamps();
    }

    public function preinscrits()
    {
        return $this->belongsToMany('App\Model\User', 'user_covoiturage_preinscrits')->withTimestamps();
    }

    public function conducteur()
    {
        return $this->belongsTo('App\Model\User', 'conducteur_id');
    }

    public function commentaires()
    {
        return $this->hasMany('App\Model\Commentaire');
    }

    public function isPast()
    {
        return Carbon::createFromTimestamp(strtotime($this->date_depart))->isPast();
    }

}