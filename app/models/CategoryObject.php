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
  // public $autoHydrateEntityFromInput = true;
  public $autoPurgeRedundantAttributes = true;
  public static $rules = array(
    'type' => 'in:IND,DIR|required|unique_with:category_objects,form,declination,has_preposition',
    'form' => 'in:NP,PR,CL|required',
    'declination' => 'in:ACC,DAT,GEN,INS|required',
    'has_preposition' => 'required',
  );
  
  public static function allForSelect($include=[])
  {
    $objects = empty($include) ? [] : $include;
    
    foreach (CategoryObject::all() as $elem) {
      $objects[$elem->id] = "{$elem->type} ( $elem->form / $elem->declination )";
      if ($elem->has_preposition)
        $objects[$elem->id] .= " +Prep";
    }
    
    return $objects;
  }
  
  
  public static function validObjectTypes()
  {
    return [
      "IND"=>"Indirect",
      "DIR"=>"Direct",
     ];
  }
  
  
  public static function validObjectForms()
  {
    return [
      "NP"=>"Noun Phrase",
      "PR"=>"Pronoun",
      "CL"=>"Clitic",
    ];
  }
  
  
  public static function validObjectDeclinations()
  {
    return[
      "ACC" => "Accusative",
      "DAT" => "Dative",
      "GEN" => "Genitive",
      "INS" => "Instrumental",
    ];
  }
}