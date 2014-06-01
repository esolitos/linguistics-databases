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
      $table->integer('first_object_id')->unsigned();
      $table->integer('second_object_id')->unsigned()->nullable();


      $table->unique( array('first_object_id', 'second_object_id') );


      $table->foreign('first_object_id', 'fir_obj_id_foreign')
        ->references('id')->on('category_objects')
        ->onDelete('restrict')->onUpdate('cascade');

      $table->foreign('second_object_id', 'sec_obj_id_foreign')
        ->references('id')->on('category_objects')
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
      $table->dropForeign('fir_obj_id_foreign');
      $table->dropForeign('sec_obj_id_foreign');
    });

    Schema::drop('occurrence_category');
  }

}
