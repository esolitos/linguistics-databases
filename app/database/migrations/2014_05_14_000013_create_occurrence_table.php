<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOccurrenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occurrence', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('category')->unsigned();
			$table->text('text');
			$table->string('verb', 50);
			$table->string('keyword', 50);
			$table->enum('speaker', array('A', 'C'));
			
			$table->string('corpus_file', 100);
			$table->integer('corpus_row')->unsigned();
			
      
			$table->index('category');
			$table->index('corpus_file');
			
			$table->foreign('category')->references('id')->on('occurrence_category')
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
		Schema::table('occurrence', function(Blueprint $table) {
			$table->dropForeign('occurrence_category_foreign');
		});
		
		Schema::drop('occurrence');
	}

}
