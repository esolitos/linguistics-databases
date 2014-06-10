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
      $table->engine = "InnoDB";
      
      $table->integer('occurrence_id')->unsigned();
      $table->enum('type', array('IND', 'DIR'));
      $table->integer('property_id')->unsigned();


      $table->primary( array('occurrence_id', 'type', 'property_id'), 'occ_type_prop_index' );

      
      $table->foreign('occurrence_id', 'occ_id_foreign')
        ->references('id')->on('occurrence')
        ->onDelete('cascade')->onUpdate('cascade');

      $table->foreign('property_id', 'prop_id_foreign')
        ->references('id')->on('object_property')
        ->onDelete('cascade')->onUpdate('cascade');
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
      $table->dropForeign('occ_id_foreign');
      $table->dropForeign('prop_id_foreign');
    });

    Schema::drop('occurrence_object_property');
  }

}
