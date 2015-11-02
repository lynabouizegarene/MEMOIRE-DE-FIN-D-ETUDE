<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('notes', function(Blueprint $table) {
			$table->foreign('noteur_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('notes', function(Blueprint $table) {
			$table->foreign('notee_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('notes', function(Blueprint $table) {
			$table->dropForeign('notes_noteur_id_foreign');
		});
		Schema::table('notes', function(Blueprint $table) {
			$table->dropForeign('notes_notee_id_foreign');
		});
	}
}