<?php

class OccurrenceObjectProperty extends Ardent {
  
  protected $table = 'occurrence_object_property';
  protected $primaryKey = 'occurrence_id'; // This is not true: used for pivot access
  public $timestamps = FALSE;
  
  protected $hidden = [];
  protected $fillable = ['occurrence_id', 'type', 'property_id'];
  protected $guarded = [];
  protected $attributes = [];
  /**
  * Ardent
  */
  public $autoHydrateEntityFromInput = true;
  public $autoPurgeRedundantAttributes = true;
  public static $rules = [
    'occurrence_id' => 'required|exists:occurrence,id|unique_with:occurrence_object_property,type,property_id',
    'type' => 'required|in:IND,DIR', 
    'property_id' => 'required|exists:object_property,id',
  ];
  
  public static $relationsData = [
    'occurrence' => [ self::HAS_ONE, 'Occurrence', 'foreignKey'=>'occurrence_id' ],
    'property' => [ self::HAS_ONE, 'ObjectProperty', 'foreignKey'=>'property_id' ],
  ];
  public static $customMessages = [];
}