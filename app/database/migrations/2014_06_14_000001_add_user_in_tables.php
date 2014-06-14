<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserInTables extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if ( ! Schema::hasColumn('occurrence_category', 'user_id') ) {
      Schema::table('occurrence_category', function(Blueprint $table)
      {
        $table->integer('user_id')->unsigned()->default('1');
        
        $table->foreign('user_id', 'cat_uid')
          ->references('id')->on('user')
          ->onDelete('restrict')->onUpdate('cascade');
      });
    }
    
    if ( ! Schema::hasColumn('occurrence', 'user_id') ) {
      Schema::table('occurrence', function(Blueprint $table)
      {
        $table->integer('user_id')->unsigned()->default('1');
        
        $table->foreign('user_id', 'occ_uid')
          ->references('id')->on('user')
          ->onDelete('restrict')->onUpdate('cascade');
      });
    }
  }


  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('user_in_tables', function(Blueprint $table)
    {
      if ( Schema::hasColumn('occurrence_category', 'user_id') ) {
        Schema::table('occurrence_category', function(Blueprint $table)
        {
          $table->dropForeign('cat_uid');
          $table->dropColumn('user_id')->unsigned();
        });
      }
    
      if ( ! Schema::hasColumn('occurrence', 'user_id') ) {
        Schema::table('occurrence', function(Blueprint $table)
        {
          $table->dropForeign('occ_uid');
          $table->dropColumn('user_id')->unsigned();
        });
      }
    });
  }

}
