<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Ville
 *
 * @property integer $id 
 * @property string $nom 
 * @property string $wilaya 
 * @property float $longitude 
 * @property float $latitude
 */
class Ville extends Model {

	protected $table = 'villes';
	public $timestamps = false;
	protected $guarded = array('id');

	public function users()
	{
		return $this->hasMany('App\Model\User');
	}

	public function departs()
	{
		return $this->hasMany('App\Model\Covoiturage', 'ville_depart_id');
	}

	public function arrivees()
	{
		return $this->hasMany('App\Model\Covoiturage', 'ville_arrivee_id');
	}

}