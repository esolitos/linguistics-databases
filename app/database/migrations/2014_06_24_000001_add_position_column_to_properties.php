<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPositionColumnToProperties extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('occurrence_object_property', function(Blueprint $table)
    {
      $table->smallInteger('position');
    });
    
    foreach ([1=>'first', 2=>'second'] as $pos => $objPosition) {
      foreach (['IND', 'DIR'] as $objType) {
        $occurrs = DB::table('category_objects AS co')
          ->join('occurrence_category AS oc', 'co.id', '=', "oc.{$objPosition}_object_id")
          ->join('occurrence AS o', 'o.category_id', '=', 'oc.id')
          ->where('co.type', '=', $objType)
          ->select('o.id AS occ_id', 'co.id AS prop_id')
          ->lists('occ_id');

        $props = DB::table('occurrence_object_property')
          ->whereIn('occurrence_id', $occurrs)
          ->where('type', '=', $objType)
          ->select('property_id')
          ->lists('property_id');

        DB::table('occurrence_object_property AS oop')
          ->whereIn('occurrence_id', $occurrs)
          ->whereIn('property_id', $props)
          ->where('type', '=', $objType)
          ->update( ['position' => $pos] );
      }
    }
  }


  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('occurrence_object_property', function(Blueprint $table)
    {
      $table->dropColumn('position');
    });
  }

}
