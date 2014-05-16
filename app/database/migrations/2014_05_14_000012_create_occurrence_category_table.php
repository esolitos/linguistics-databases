<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOccurrenceCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence_category', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('first_object')->unsigned();
			$table->integer('second_object')->unsigned()->nullable();
			
			$table->unique( array('first_object', 'second_object') );
			
			$table->foreign('first_object')->references('id')->on('category_objects')
				->onDelete('restrict')->onUpdate('cascade');
			
			$table->foreign('second_object')->references('id')->on('category_objects')
				->onDelete('restrict')->onUpdate('cascade');
		});
		
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('occurrence_category', function(Blueprint $table) {
			$table->dropForeign('occurrence_category_first_object_foreign');
			$table->dropForeign('occurrence_category_second_object_foreign');
		});
		
		Schema::drop('occurrence_category');
	}

}
