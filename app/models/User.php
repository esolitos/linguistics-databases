<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Ardent implements UserInterface, RemindableInterface
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    protected $softDelete = true;

    public $timestamps = true;

    protected $hidden = [ 'password' ];

    protected $fillable = [ 'username', 'email', 'full_name', 'profession', 'password', 'password_confirmation', ];

    protected $guarded = [ 'id', 'password', 'remember_token' ];

    /**
     * Ardent
     */
    public $autoPurgeRedundantAttributes = true;

    public static $rules = [
        'username'   => 'required|between:4,100|unique:user',
        'full_name'  => 'required|between:5,100',
        'profession' => 'between:4,50',
        'email'      => 'required|email|unique:user',
    ];

    public static $relationsData = [
        'categories'  => [ self::HAS_MANY, 'OccurrenceCategory', 'otherKey' => 'user_id' ],
        'occurrences' => [ self::HAS_MANY, 'Occurrence', 'otherKey' => 'user_id' ],
        'roles'       => [ self::BELONGS_TO_MANY, 'Role', 'table' => 'role_user' ],
        'permissions' => [ self::HAS_MANY, 'Permission', 'otherKey' => 'user_id' ],
    ];


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }


    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }


    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }


    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }


    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }


    /**
     * @param string|Role $key
     *
     * @return bool
     */
    public function hasRole($key)
    {
        if (is_object($key)) {
            if ( ! $key instanceof Role) {
                throw new UnexpectedValueException('Key can only be an instance of Role');
            }
            $key = $key ->name;
        }

        foreach ($this->roles as $role) {
            if ($role->name === $key) {
                return true;
            }
        }

        return false;
    }
}
