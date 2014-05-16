<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOccurrenceObjectPropertyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence_object_property', function(Blueprint $table) {
			$table->integer('occurrence')->unsigned();
			$table->enum('type', array('IND', 'DIR'));
			$table->integer('property')->unsigned();
			
			$table->primary( array('occurrence', 'type') );
			
			$table->foreign('occurrence')->references('id')->on('occurrence')
				->onDelete('cascade')->onUpdate('cascade');
			
			$table->foreign('property')->references('id')->on('object_property')
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
		Schema::table('occurrence_object_property', function(Blueprint $table) {
			$table->dropForeign('occurrence_object_property_occurrence_foreign');
			$table->dropForeign('occurrence_object_property_property_foreign');
		});
		
		Schema::drop('occurrence_object_property');
	}

}
