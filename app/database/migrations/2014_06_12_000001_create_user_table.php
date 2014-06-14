<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::create('user', function(Blueprint $table)
    {
      $table->engine = "InnoDB";
      
      $table->increments("id");
      $table->string("username");
      $table->string("password");
      $table->string("email");
      $table->string("remember_token")->nullable();

      $table->timestamps();
      $table->softDeletes();
    });
    
    $DB = DB::connection();
    $DB->statement("SET SESSION sql_mode='NO_AUTO_VALUE_ON_ZERO'");
    $DB->table('user')->insert([
      [
        'id' => 0,
        'username' => 'anonymous',
        'password' => '0',
        'email' => 'no-reply@mail.com', 
      ],
      [
        'id' => 1,
        'username' => 'admin',
        'password' => Hash::make('password'),
        'email' => 'root@localhost', 
      ],
    ]);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('user');
  }

}
