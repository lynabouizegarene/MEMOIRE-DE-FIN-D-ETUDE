<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Notification
 *
 * @property integer $id 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $contenu 
 * @property integer $user_id 
 * @property string $url 
 * @property boolean $vu
 */
class Notification extends Model {

	protected $table = 'notifications';
	public $timestamps = true;
	protected $guarded = array('id','timestamps');

	public function user()
	{
		return $this->belongsTo('App\Model\User');
	}

}