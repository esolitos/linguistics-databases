<?php

class Occurrence extends Ardent {
  
  protected $table = 'occurrence';
  // protected $softDelete = true;
  public $timestamps = false;
  
  protected $hidden = [];
  protected $fillable = ['category_id', 'text', 'verb', 'keyword', 'speaker', 'corpus_file', 'corpus_row'];
  protected $guarded = ['id'];
  protected $attributes = [];
  /**
  * Ardent
  */
  public $autoHydrateEntityFromInput = true;
  public $autoPurgeRedundantAttributes = true;
  public static $rules = array(
    'category_id'  => 'required|exists:occurrence_category,id',
    'text'      => 'required',
    'verb'      => 'required|max:50',
    'keyword'   => 'required|max:50',
    'speaker'   => 'required|in:A,C',
    'corpus_file' => 'required|max:100',
    'corpus_row'  => 'required|integer|min:1',
  );
  public static $relationsData = array(
    'category' => [self::BELONGS_TO, 'OccurrenceCategory', 'foreignKey'=>'category_id'],
  );
  
  
  public static function validSpeakers()
  {
    return [
      "A"=>"Adult",
      "C"=>"Child",
     ];
  }
}