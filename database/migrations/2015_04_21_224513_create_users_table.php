<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email', 255)->unique();
			$table->rememberToken('remember_token');
			$table->timestamps();
			$table->string('nom', 255);
			$table->string('prenom', 255);
			$table->string('password', 60);
			$table->string('genre', 5);
			$table->date('date_nais');
			$table->string('num_tel', 13);
			$table->boolean('pref_musique')->default(true);
			$table->boolean('pref_animeaux')->default(true);
			$table->boolean('pref_discussion')->default(true);
			$table->boolean('pref_fumeur')->default(true);
			$table->integer('ville_id')->unsigned();
			$table->text('description')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}