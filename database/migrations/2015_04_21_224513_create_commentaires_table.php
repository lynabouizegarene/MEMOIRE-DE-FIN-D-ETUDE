<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentairesTable extends Migration {

	public function up()
	{
		Schema::create('commentaires', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('contenu');
			$table->integer('user_id')->unsigned();
			$table->integer('covoiturage_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('commentaires');
	}
}