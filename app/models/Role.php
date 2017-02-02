<?php

use LaravelBook\Ardent\Ardent;

class Role extends Ardent
{

    /**
     * Super-user: can do anything
     */
    const ADMIN = 'admin';
    /**
     * Full access, very little restrictions
     */
    const MANAGER = 'manager';
    /**
     * Can consult and execute simple data entry
     */
    const DATA_ENTRY = 'writer';
    /**
     * Can consult the db but no write action is allowed
     */
    const READER = 'reader';

    protected $table = 'roles';

    protected $softDelete = false;

    public $timestamps = true;
}