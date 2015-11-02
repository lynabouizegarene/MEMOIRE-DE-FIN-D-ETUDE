<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserCovoituragePreinscritsTable extends Migration {

	public function up()
	{
		Schema::create('user_covoiturage_preinscrits', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('covoiturage_id')->unsigned();
			$table->integer('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('user_covoiturage_preinscrits');
	}
}