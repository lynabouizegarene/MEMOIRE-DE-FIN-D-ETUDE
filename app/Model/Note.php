<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Note
 *
 * @property integer $id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property integer $note 
 * @property string $avis 
 * @property integer $noteur_id 
 * @property integer $notee_id
 */
class Note extends Model {

	protected $table = 'notes';
	public $timestamps = true;
    public $guarded=['id','timestamps'];

	public function noteur()
	{
		return $this->belongsTo('App\Model\User', 'noteur_id');
	}

	public function notee()
	{
		return $this->belongsTo('App\Model\User', 'notee_id');
	}

}