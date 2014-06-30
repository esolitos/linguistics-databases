<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ForeignKeysAddAclTables extends Migration {

  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::table('acl_permissions', function(Blueprint $table) {

      $table->foreign('group_id', 'acl_permissions_group_id_foreign')
        ->references('id')->on('acl_groups')
          ->onDelete('restrict')
          ->onUpdate('cascade');
    });

    Schema::table('acl_users_permissions', function(Blueprint $table) {

      $table->foreign('permission_id', 'acl_users_permissions_id_foreign')
        ->references('id')->on('acl_permissions')
          ->onDelete('restrict')
          ->onUpdate('cascade');

      $users_table = Config::get('acl::users_table', 'users');
      if ( Schema::hasTable($users_table) ) {
        $table->foreign('user_id', 'acl_users_id_foreign')
          ->references('id')->on($users_table)
            ->onDelete('restrict')
            ->onUpdate('cascade');
      }
    });

    Schema::table('acl_roles_permissions', function(Blueprint $table) {
            
      $table->foreign('role_id', 'acl_roles_permissions_role_id_foreign')
        ->references('id')->on('acl_roles')
          ->onDelete('restrict')
          ->onUpdate('cascade');
    });

    Schema::table('acl_users_roles', function(Blueprint $table) {
        
      $users_table = Config::get('acl::users_table', 'users');
        
      if ( Schema::hasTable($users_table) ) {
        $table->foreign('user_id', 'acl_users_roles_user_id_foreign')
          ->references('id')->on($users_table)
            ->onDelete('restrict')
            ->onUpdate('cascade');
      }
          
      $table->foreign('role_id', 'acl_users_roles_role_id_foreign')
        ->references('id')->on('acl_roles')
          ->onDelete('restrict')
          ->onUpdate('cascade');
    });
    
    
    
  }

  /**
  * Reverse the migrations.
  *
  * @return void
  */
  public function down()
  {
    
    Schema::table('acl_permissions', function(Blueprint $table) {
      $table->dropForeign('acl_permissions_group_id_foreign');
    });

    Schema::table('acl_users_permissions', function(Blueprint $table) {
      $table->dropForeign('acl_users_permissions_id_foreign');

      $users_table = Config::get('acl::users_table', 'users');
      if ( Schema::hasTable($users_table) ) {
        $table->dropForeign('acl_users_id_foreign');
      }
    });

    Schema::table('acl_roles_permissions', function(Blueprint $table) {
      $table->dropForeign('acl_roles_permissions_role_id_foreign');      
    });

    Schema::table('acl_users_roles', function(Blueprint $table) {
      
      $users_table = Config::get('acl::users_table', 'users');
        
      if ( Schema::hasTable($users_table) ) {
      $table->dropForeign('acl_users_roles_user_id_foreign');
      }
      
      $table->dropForeign('acl_users_roles_role_id_foreign');
    });    
  }

}
