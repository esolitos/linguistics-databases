<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserDetails extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('user', function(Blueprint $table)
    {
      $table->string('full_name', 100)->nullable()->after('username');
      $table->string('profession', 50)->nullable()->after('username');
    });

    DB::table('user')
      ->where('username', '=', 'anonymous')
      ->update(['full_name'=>'Anonymous User']);

    DB::table('user')
      ->where('username', '=', 'admin')
      ->update(['full_name'=>'Administration User']);
  }


  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('user', function(Blueprint $table)
    {
      $table->dropColumn(['full_name', 'profession']);
    });
  }

}
