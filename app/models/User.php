<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Ardent implements UserInterface, RemindableInterface {

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'user';
  protected $softDelete = true;
  public $timestamps = true;

  protected $hidden = ['password'];
  protected $fillable = ['username', 'email'];
  protected $guarded = ['id', 'password', 'remember_token'];
	
  /**
  * Ardent
  */
  public $autoPurgeRedundantAttributes = true;
  public static $rules = array(
    'username' => 'required|between:4,50|unique:user',
    'email' => 'required|email|unique:user',
    'password' => 'required|alpha_num|min:8|confirmed',
    'password_confirmation' => 'required|alpha_num|min:8',
  );
  public static $relationsData = array(
    'categories'  => [self::HAS_MANY, 'OccurrenceCategory', 'otherKey'=>'user_id'],
    'occurrences' => [self::HAS_MANY, 'Occurrence', 'otherKey'=>'user_id'],
  );

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
   * @param  string  $value
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
}
