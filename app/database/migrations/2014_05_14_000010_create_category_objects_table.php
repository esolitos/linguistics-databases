<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryObjectsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('category_objects', function(Blueprint $table) {
      $table->increments('id');
      $table->enum('type', array('IND', 'DIR'));
      $table->enum('form', array('NP', 'PR', 'CL'));
      $table->enum('declination', array('ACC', 'DAT', 'GEN', 'INS'));
      $table->boolean('has_preposition');


      $table->unique( array('type', 'form', 'declination', 'has_preposition') );
    });
  }


  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('category_objects');
  }

}
