<?php

class OccurrenceCategory extends Ardent {
  
  protected $table = 'occurrence_category';
  public $timestamps = FALSE;
  
  protected $hidden = [];
  protected $fillable = ['first_object_id', 'second_object_id'];
  protected $guarded = ['id'];
  protected $attributes = [];
  /**
  * Ardent
  */
  public $autoHydrateEntityFromInput = true;
  public $autoPurgeRedundantAttributes = true;
  public static $rules = array(
    'first_object_id' => 'required|exists:category_objects,id|unique_with:occurrence_category,second_object_id',
    'second_object_id' => 'exists:category_objects,id',
  );
  public static $relationsData = array(
    'occurrences' => [self::HAS_MANY, 'Occurrence', 'otherKey'=>'category'],
  );
  public static $customMessages = array(
    'unique_with' => 'This combination of those two objects already exists.',
  );
  
  public static function allForSelect($include=[])
  {
    $categories = empty($include) ? [] : $include;
    
    foreach (OccurrenceCategory::with(['firstObj', 'secondObj'])->get() as $elem) {
      $first_prep = ($elem->firstObj->has_preposition) ? 'P': '-';
      
      if ( $elem->secondObj ) {
        $second_prep = ($elem->secondObj->has_preposition) ? 'P': '-';
        
        $categories[$elem->id] = "{$elem->firstObj->type}-{$elem->secondObj->type}   ( {$elem->firstObj->form}-{$elem->secondObj->form} // {$elem->firstObj->declination}-{$elem->secondObj->declination} ) {$first_prep}/{$second_prep}";
      } else {
        $categories[$elem->id] = "{$elem->firstObj->type}  ( {$elem->firstObj->form} // {$elem->firstObj->declination} ) {$first_prep}";
      }
    }
    // arsort($categories, SORT_STRING);
    return $categories;
  }
  
  
  public function firstObj()
  {
    return $this->belongsTo('CategoryObject', 'first_object_id', 'id');
  }
  
  public function secondObj()
  {
    return $this->belongsTo('CategoryObject', 'second_object_id', 'id');
  }
}