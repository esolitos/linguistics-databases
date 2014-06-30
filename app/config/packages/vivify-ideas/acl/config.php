<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Permission Provider
    |--------------------------------------------------------------------------
    |
    | This option controls what provider will ACL use.
    | Currently there is only one provider "eloquent".
    |
    | Supported: "eloquent"
    |
    */
    'provider' => 'eloquent',

    /*
    |--------------------------------------------------------------------------
    | Eloquent: Users Table
    |--------------------------------------------------------------------------
    |
    | Insert here the table containing the users.
    | It will be used to create foreign keys in the database
    |
    | Currently used only by the provider "eloquent".
    |
    */
    'users_table' => 'user',

    /*
    |--------------------------------------------------------------------------
    | Eloquent: Create Foreign Keys
    |--------------------------------------------------------------------------
    |
    | Specify if the eloquent permissions provider should use foreign keys.
    |
    | Used only if the provider is "eloquent".
    |
    */
    'use_foreign_key' => TRUE,

    /*
    |--------------------------------------------------------------------------
    | Super users array
    |--------------------------------------------------------------------------
    |
    | Put here user IDs that will have superuser rights.
    |
    */
    'superusers' => array(1),

    /*
    |--------------------------------------------------------------------------
    | Guest users ID
    |--------------------------------------------------------------------------
    |
    | Put here ID that will used for setting permissions to guest users.
    |
    */
    'guestuser' => 0,

    /*
    |--------------------------------------------------------------------------
    | Permissions in the application
    |--------------------------------------------------------------------------
    |
    | This option needs to contain all system wide permissions.
    |
    | Example:

        'permissions' => array(
            // users
            array(
                'id' => 'CREATE_USER',
                'name' => 'Create User',
                'allowed' => false,
                'route' => array('GET:/user/admin/create', 'POST:/user/admin'),
                'resource_id_required' => false,
                'group_id' => 'MANAGE_USERS'
            ),
            array(
                'id' => 'EDIT_USER',
                'name' => 'Edit User',
                'allowed' => false,
                'route' => array(
                    'GET:/user/admin/(\d+)/edit',
                    'PUT:/user/admin/(\d+)',
                    'GET:/user/admin/(\d+)/permissions',
                    'PUT:/user/admin/(\d+)/permissions',
                    'PUT:/user/admin/(\d+)/member-type'
                ),
                'resource_id_required' => true,
                'group_id' => 'MANAGE_USERS'
            ),
            array(
                'id' => 'DELETE_USER',
                'name' => 'Delete User',
                'allowed' => false,
                'route' => array('DELETE:/user/admin/(\d+)'),
                'resource_id_required' => true,
                'group_id' => 'MANAGE_USERS'
            ),

            // categories
            array(
                'id' => 'CREATE_CATEGORY',
                'name' => 'Create Category',
                'allowed' => false,
                'route' => array('GET:/admin/categories/create', 'POST:/admin/categories'),
                'resource_id_required' => false,
                'group_id' => 'MANAGE_CATEGORIES'
            ),
            array(
                'id' => 'EDIT_CATEGORY',
                'name' => 'Edit Category',
                'allowed' => false,
                'route' => array('GET:/admin/categories/(\d+)/edit', 'PUT:/admin/categories/(\d+)'),
                'resource_id_required' => true,
                'group_id' => 'MANAGE_CATEGORIES'
            ),
            array(
                'id' => 'DELETE_CATEGORY',
                'name' => 'Delete Category',
                'allowed' => false,
                'route' => array('DELETE:/admin/categories/(\d+)'),
                'resource_id_required' => true,
                'group_id' => 'MANAGE_CATEGORIES'
            ),

            // Account Settings
            array(
                'id' => 'EDIT_ACCOUNT_SETTINGS',
                'name' => 'Edit Account Settings',
                'allowed' => false,
                'route' => '.*:/admin/settings',
                'resource_id_required' => false,
                'group_id' => 'ADMIN_PRIVILEGES'
            ),
        ),
    */
    
    'permissions' => array(
      
      array(
        'id' => 'VIEW_OTHER_USER',
        'name' => 'View other Users',
        'allowed' => false,
        'route' => array(
          'GET:/admin/users',
          'GET:/user/show/(\d+)',
        ),
        'resource_id_required' => false,
        'group_id' => 'MANAGE_USERS'
      ),
      array(
        'id' => 'CREATE_USER',
        'name' => 'Create User',
        'allowed' => false,
        'route' => array(
          'GET:/admin/users/create',
          'POST:/admin/users/create',
        ),
        'resource_id_required' => false,
        'group_id' => 'MANAGE_USERS'
      ),
      array(
        'id' => 'EDIT_USER',
        'name' => 'Edit User',
        'allowed' => false,
        'route' => array(
          'GET:/admin/users/(\d+)/edit',
          'PUT:/admin/users/(\d+)',
        ),
        'resource_id_required' => true,
        'group_id' => 'MANAGE_USERS'
      ),
      array(
        'id' => 'DELETE_USER',
        'name' => 'Delete User',
        'allowed' => false,
        'route' => array(
          'GET:/admin/users/(\d+)/delete',
          'DELETE:/admin/users/(\d+)',
        ),
        'resource_id_required' => true,
        'group_id' => 'MANAGE_USERS'
      ),
      array(
        'id' => 'EDIT_USER_PERM',
        'name' => 'Edit User',
        'allowed' => false,
        'route' => array(
          'GET:/admin/users/(\d+)/permissions',
          'PUT:/admin/users/(\d+)/permissions',
          'PUT:/admin/users/(\d+)/member-type'
        ),
        'resource_id_required' => true,
        'group_id' => 'MANAGE_USERS'
      ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Permission groups
    |--------------------------------------------------------------------------
    |
    | Every permission can belong to some group. You can have groups that
    | belongs to other group. Every group can have a route.
    |
    | Example:
        'groups' => array(
            array(
                'id' => 'ADMIN_PRIVILEGES',
                'name' => 'Administrative Privileges',
                'route' => 'GET:/admin',

                'children' => array(
                    array(
                        'id' => 'MANAGE_USERS',
                        'name' => 'Manage Users',
                        'route' => 'GET:/user/admin'
                    ),
                    array(
                        'id' => 'MANAGE_CATEGORIES',
                        'name' => 'Manage Categories',
                        'route' => 'GET:/admin/categories'
                    ),
                    array(
                        'id' => 'MANAGE_BUNDLES',
                        'name' => 'Manage Bundles',
                        'route' => 'GET:/admin/bundles'
                    )
                )
            )
        ),
    */
    'groups' => array(
      array(
        'id' => 'ADMIN_PRIVILEGES',
        'name' => 'Administrative Privileges',
        'route' => 'GET:/admin',

        'children' => array(
          array(
            'id' => 'MANAGE_USERS',
            'name' => 'Manage Users',
            'route' => 'GET:/admin/users'
          ),
        ),
      ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    |
    | Roles can have set of permissions as well as parent and children roles.
    | To use roles add roles column to your users table.
    |
    |
    | Example:
       'roles' => array(
            array(
                'id' => 'ADMIN',
                'name' => 'Admin',
            ),
            array(
                'id' => 'MODERATOR',
                'name' => 'Moderator',
            )
       ),
   */
    'roles' => array(
      [
        'id' => 'ADMIN',
        'name' => 'Administrator',
      ],
      [
        'id' => 'LINGUIST',
        'name' => 'Linguist',
      ],
      [
        'id' => 'RESEARCHER',
        'name' => 'Researcher',
      ],
      [
        'id' => 'ASSISTANT',
        'name' => 'Assistant',
      ],
      [
        'id' => 'VISITOR',
        'name' => 'Visitor',
      ],
    ),

);

