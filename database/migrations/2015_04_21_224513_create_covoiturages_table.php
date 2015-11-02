<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCovoituragesTable extends Migration {

	public function up()
	{
		Schema::create('covoiturages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('ville_depart_id')->unsigned();
			$table->integer('ville_arrivee_id')->unsigned();
			$table->integer('conducteur_id')->unsigned();
			$table->timestamp('date_depart');
			$table->string('vehicule', 255);
			$table->integer('prix');
			$table->text('details')->nullable();
			$table->string('bagage', 255);
			$table->string('flexibilite_horaire', 255);
			$table->integer('nombre_places');
		});
	}

	public function down()
	{
		Schema::drop('covoiturages');
	}
}