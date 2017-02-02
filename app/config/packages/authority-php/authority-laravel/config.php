<?php

return [

    'initialize' => function (Authority\Authority $authority) {
        $user = Auth::guest() ? new User() : $authority->getCurrentUser();

        // Admin Users
        // Admin Data
        // Entry Data
        // Consult Data

        $authority->addAlias(Permission::ADMINISTER,
            [ Permission::ACTION_C, Permission::ACTION_R, Permission::ACTION_U, Permission::ACTION_D ]);

        // Define abilities for the passed in user here. For example:
        if ($user->hasRole(Role::ADMIN)) {
            $authority->allow(Permission::ADMINISTER, Permission::ACTION_ALL);
        }
        elseif ($user->hasRole(Role::MANAGER)) {

        }
        elseif ($user->hasRole(Role::DATA_ENTRY)) {
            /*
             * Allow Create and Read on any resource (except Users),
             *  and Update on content owned by self.
             */
            $authority->allow(Permission::ACTION_C, Permission::ACTION_ALL);
            $authority->allow(Permission::ACTION_R, Permission::ACTION_ALL);
            $authority->allow(Permission::ACTION_U, Permission::ACTION_ALL);
            // Deny any action on Users
            $authority->deny('admin', User::class);
        }
        elseif ($user->hasRole(Role::READER)) {
            /**
             * Allow Read on all the content
             */
            $authority->allow(Permission::ACTION_R, 'all');
        }

        // Finally loop through each of the users permissions and create rules
        foreach ($user->permissions as $perm) {
            if ($perm->type == Permission::ALLOW) {
                $authority->allow($perm->action, $perm->resource);
            }
            else {
                $authority->deny($perm->action, $perm->resource);
            }
        }
    },
];
