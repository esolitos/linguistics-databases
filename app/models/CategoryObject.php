<?php

class CategoryObject extends Ardent {
  
  protected $table = 'category_objects';
  public $timestamps = FALSE;
  
  protected $hidden = [];
  protected $fillable = ['type', 'form', 'declination', 'has_preposition'];
  protected $guarded = ['id'];
  protected $attributes = [
    'has_preposition' => FALSE,
  ];
  /**
  * Ardent
  */
  public $autoPurgeRedundantAttributes = true;
  public static $rules = array(
    'type' => 'in:IND,DIR|required|unique_with:category_objects,form,declination,has_preposition',
    'form' => 'in:NP,PR,CL|required',
    'declination' => 'in:ACC,DAT,GEN,INS|required',
    'has_preposition' => 'required|boolean',
  );
}