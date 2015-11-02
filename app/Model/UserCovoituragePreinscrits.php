<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserCovoituragePreinscrits
 *
 * @property integer $id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property integer $covoiturage_id 
 * @property integer $user_id
 */
class UserCovoituragePreinscrits extends Model {

	protected $table = 'user_covoiturage_preinscrits';
	public $timestamps = true;

}