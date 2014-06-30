<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAclTables extends Migration {

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('acl_groups', function(Blueprint $table) {
      $table->engine = "InnoDB";
        
      $table->string('id')->primary();
      $table->string('name');
      $table->text('route')->nullable();
      $table->string('parent_id')->index()->nullable();
    });

    Schema::create('acl_roles', function(Blueprint $table) {
      $table->engine = "InnoDB";
          
      $table->string('id')->primary();
      $table->string('name');
      $table->string('parent_id')->index()->nullable();
    });

    Schema::create('acl_permissions', function(Blueprint $table) {
      $table->engine = "InnoDB";

      $table->string('id')->primary();
      $table->boolean('allowed');
      $table->text('route');
      $table->boolean('resource_id_required');
      $table->string('name');
      $table->string('group_id')->nullable();
    });

    Schema::create('acl_users_permissions', function(Blueprint $table) {
      $table->engine = "InnoDB";
        
      $table->increments('id');
      $table->string('permission_id')->index();
      $table->integer('user_id')->unsigned()->index();
      $table->boolean('allowed')->nullable();
      $table->string('allowed_ids')->nullable();
      $table->string('excluded_ids')->nullable();
        
    });

    Schema::create('acl_roles_permissions', function(Blueprint $table) {
      $table->engine = "InnoDB";
          
      $table->increments('id');
      $table->string('permission_id')->index();
      $table->string('role_id')->index();
      $table->boolean('allowed')->nullable();
      $table->string('allowed_ids')->nullable();
      $table->string('excluded_ids')->nullable();

    });

    Schema::create('acl_users_roles', function(Blueprint $table) {
      $table->engine = "InnoDB";

      $table->integer('user_id')->unsigned();
      $table->string('role_id');

      $table->index('user_id','role_id');
    });
    
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    Schema::drop('acl_users_roles');
    Schema::drop('acl_roles_permissions');
    Schema::drop('acl_users_permissions');
    Schema::drop('acl_permissions');
    Schema::drop('acl_roles');
    Schema::drop('acl_groups');
    
  }

}
