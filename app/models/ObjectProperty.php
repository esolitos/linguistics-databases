<?php

class ObjectProperty extends Ardent {
  
  protected $table = 'object_property';
  public $timestamps = FALSE;
  
  protected $hidden = [];
  protected $fillable = ['name'];
  protected $guarded = ['id'];
  protected $attributes = [];
  /**
  * Ardent
  */
  public $autoHydrateEntityFromInput = true;
  public $autoPurgeRedundantAttributes = true;
  public static $rules = array(
    'name' => 'required|max:20|unique:object_property',
  );
  
  
  public static function allForSelect($include=[])
  {
    $objects = empty($include) ? [] : $include;
    
    foreach (ObjectProperty::all() as $elem) {
      $objects[$elem->id] = ucwords($elem->name);
    }
    
    return $objects;
  }
}