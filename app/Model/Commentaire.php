<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Commentaire
 *
 * @property integer $id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $contenu 
 * @property integer $user_id 
 * @property integer $covoiturage_id
 */
class Commentaire extends Model {

	protected $table = 'commentaires';
	public $timestamps = true;
    protected  $guarded = array('id', 'timestamps');

	public function user()
	{
		return $this->belongsTo('App\Model\User');
	}

	public function covoiturage()
	{
		return $this->belongsTo('App\Model\Covoiturage');
	}

}