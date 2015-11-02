<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('contenu', 255);
			$table->integer('user_id')->unsigned();
			$table->string('url');
			$table->boolean('vu');
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}