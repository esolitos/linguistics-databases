<?php

use LaravelBook\Ardent\Ardent;

class Permission extends Ardent
{

    const ALLOW    = 'allow';
    const DISALLOW = 'disallow';

    /*
     * CRUD Permissions + Wildcard
     */
    const ACTION_C   = 'create';
    const ACTION_R   = 'read';
    const ACTION_U   = 'update';
    const ACTION_D   = 'delete';
    const ACTION_ALL = 'all';

    const CRUD_ACTIONS = [
        self::ACTION_C,
        self::ACTION_R,
        self::ACTION_U,
        self::ACTION_D,
    ];

    const ADMINISTER = 'admin';

    const ALL_RESOURCES = [
        'CategoryObject',
        'ObjectProperty',
        'Occurrence',
        'OccurrenceCategory',
        'OccurrenceObjectProperty',
        'Role',
        'User',
    ];

    protected $table = 'permissions';

    protected $softDelete = false;

    public $timestamps = true;

    public static $relationsData = [
        'user' => [ self::HAS_ONE, 'User' ],
    ];

}