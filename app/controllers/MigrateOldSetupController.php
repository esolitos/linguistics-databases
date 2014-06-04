<?php


class MigrateOldSetupController extends BaseController {


  public function getIndex()
  {
    Redis::select(2);
    Redis::flushdb();
    return Redirect::action('MigrateOldSetupController@getCategories') ;
  }
  
  public function getCompleted()
  {
    return "Migration completed!";
  }
  
  
  public function getCategories()
  {
    Redis::select(2);
    $old_categories = DB::connection('old-mysql')->table('double_obj_structure')->get();
        
    foreach ($old_categories as $oldCat) {
      $oldCat_order = [];
      $num_matches = preg_match("/([ID]O)\-?([ID]O)?/", $oldCat->object_order, $oldCat_order);
      $oldCat_order[0] = ''; // Remove first match, we don't care about it
      
      $newCat = new OccurrenceCategory();
      
      
      $pos = 'first';
      $new_cat_obj = $newCat_id = 0;
      // DIRECT Object creation or definition
      if ( array_search("DO", $oldCat_order) !== FALSE ) {
        $pos = (array_search("DO", $oldCat_order) === 1) ? 'first' : 'second';
        
        $objects = CategoryObject::where('type', '=', 'DIR')
          ->where('form', '=', $oldCat->{$pos.'_object_form'} )
          ->where('declination', '=', $oldCat->{$pos.'_object_case'});
        
        if ( $objects->count() ) {
          
          $new_cat_obj = $objects->get(['id'])->first();
          echo "DIR Find: {$pos} -> {$new_cat_obj->id}<br>";

        } else {
          $new_cat_obj = new CategoryObject([
            'type' => 'DIR',
            'form' => $oldCat->{$pos.'_object_form'},
            'declination' => $oldCat->{$pos.'_object_case'},
          ]);
          
          if($new_cat_obj->save()) {
            echo "DIR Created: {$pos} -> {$new_cat_obj->id}<br>";
          } else {
            var_dump($new_cat_obj->errors());
            return "DIRECT OBJECT ERROR!";
          }
        }
        
        $newCat->{$pos.'_object_id'} = $new_cat_obj->id;
        
      } // DIRECT Object
      
      // INDIRECT Object creation or definition
      if ( array_search("IO", $oldCat_order) !== FALSE ) {
        $pos = (array_search("IO", $oldCat_order) === 1) ? 'first' : 'second';
        
        $objects = CategoryObject::where('type', '=', 'IND')
          ->where('form', '=', $oldCat->{$pos.'_object_form'} )
          ->where('declination', '=', $oldCat->{$pos.'_object_case'});
        
        if ( $objects->count() ) {
          
          $new_cat_obj = $objects->get(['id'])->first();
          echo "IND Find: {$pos} -> {$new_cat_obj->id}<br>";

        } else {
          $new_cat_obj = new CategoryObject([
            'type' => 'IND',
            'form' => $oldCat->{$pos.'_object_form'},
            'declination' => $oldCat->{$pos.'_object_case'},
            'has_preposition' => $oldCat->has_preposition,
          ]);
          
          if($new_cat_obj->save()) {
            echo "IND Created: {$pos} -> {$new_cat_obj->id} <br>";
          } else {
            var_dump($new_cat_obj->errors());
            return "INDIRECT OBJECT ERROR!";
          }
        }

        $newCat->{$pos.'_object_id'} = $new_cat_obj->id;
        
      } // INDIRECT Object
      
      $existing_cat = OccurrenceCategory::where('first_object_id', '=', $newCat->first_object_id)
        ->where('second_object_id', '=', $newCat->second_object_id)->get();
      
      if ( $existing_cat->count() ) {
        $newCat_id = $existing_cat->first()->id;
        echo "CATEGORY Exist: {$newCat_id}<br><br>";
        
      } else {
        // Saving category
        if ($newCat->save()) {
          $newCat_id = $newCat->id;
          echo "CATEGORY Created: {$newCat_id}<br><br>";
        } else {
          var_dump($newCat);
          echo "<hr>";
          var_dump($newCat->errors());
          return "CATEGORY ERROR!";
        }
      }
      
      Redis::set("oldCat:{$oldCat->id}", $newCat_id);
    }
    
    return Redirect::action('MigrateOldSetupController@getProperties') ;
  }



  public function getProperties()
  {
    Redis::select(2);
    $old_properties = DB::connection('old-mysql')->table('object_properties_definition')->get();
    
    foreach ($old_properties as $oldProp) {
      $existProp = ObjectProperty::where('name', '=', $oldProp->name)->get();
      
      $newProp_id = 0;
      if ( $existProp->count() ) {
        $newProp_id = $existProp->first()->id;
        echo "Property FOUND: {$newProp_id} <br>";
      } else {
        $newProp = new ObjectProperty(['name' => $oldProp->name]);
        
        if ( $newProp->save() ) {
          $newProp_id = $newProp->id;
          echo "Property CREATED: {$newProp_id} <br>";
        } else {
          var_dump($newProp->errors());
          return "OBJECT PROPERTY ERROR!";
        }
      }
      
      Redis::set("oldProp:{$oldProp->id}", $newProp_id);
    }
    
    return Redirect::action('MigrateOldSetupController@getOccurrence') ;
    
  }
  
  
  public function getOccurrence()
  {
    Redis::select(2);
    $old_occurrences = DB::connection('old-mysql')->table('occurrences')->get();
    
    foreach ($old_occurrences as $oldOccurr) {
      $newCategory = Redis::get("oldCat:{$oldOccurr->do_cat_id}");
      
      // var_dump( Occurrence::get()->first() );
      // dd($oldOccurr);
      
      if ( !$newCategory ) {
        var_dump($newCategory);
        return "OCCURRENCE OLD-CATEGORY ERROR!";
      }
      
      $oldCorpus = [];
      preg_match('/(.{1,})\:([0-9]{1,})/', $oldOccurr->corpus_coord, $oldCorpus);
      
      $newOccurr = new Occurrence([
        'category_id' => $newCategory,
        /*
          'text' => utf8_encode($oldOccurr->text),
          'keyword' => utf8_encode($oldOccurr->keyword),
          'verb' => utf8_encode($oldOccurr->verb),
        */
        'text' => $oldOccurr->text,
        'keyword' => $oldOccurr->keyword,
        'verb' => $oldOccurr->verb,
        'speaker' => $oldOccurr->speaker,
        'corpus_file' => $oldCorpus[1],
        'corpus_row' => $oldCorpus[2],
      ]);
            
      if ( $newOccurr->save() ) {
        Redis::set("oldOccurr:{$oldOccurr->id}", $newOccurr->id);
        echo "Occurrence CREATED: {$newOccurr->id} <br>";

      } else {
        var_dump($newOccurr->errors());
        return "OCCURRENCE ERROR!";
      }
    }
    
    return Redirect::action('MigrateOldSetupController@getObjectProperties') ;
  }
  
  
  public function getObjectProperties()
  {
    Redis::select(2);
    $oldDB = DB::connection('old-mysql');

    echo "Copying Properties<br><br>";
    $old_objects = $oldDB->table('occurrence_objects')->orderBy('occurr_id')->get();
    
    $newProperties = [];
    // $sql = "INSERT IGNORE INTO `occurrence_object_property` (`occurrence_id`, `property_id`, `type`) VALUES ";
    
    foreach ($old_objects as $oldObj) {
      $newOccurr_id = Redis::get("oldOccurr:{$oldObj->occurr_id}");
      $type = ($oldObj->obj_type == 'DO') ? 'DIR' : 'IND';
      
      echo "<br>Occurrence {$oldObj->occurr_id} => {$newOccurr_id}, Obj: {$type}<br>";
      
      $old_properties = $oldDB->table('object_vs_properties')->where('id_obj', '=', $oldObj->id)->get();
      foreach ($old_properties as $oldObjProp) {
        $newProp_id = Redis::get("oldProp:{$oldObjProp->id_prop}");
        echo "Property {$oldObjProp->id_prop} => {$newProp_id}<br>";
        
        $newProperties[] = [
          'occurrence_id' => $newOccurr_id,
          'type' => $type,
          'property_id' => $newProp_id,
        ];
        // $sql .= "({$newOccurr_id}, {$newProp_id}, '{$type}'), ";
      }
    }
    
    
    // DB::statement( substr($sql, 0, -2) );
    
    OccurrenceObjectProperty::insert($newProperties);
    
    return Redirect::action('MigrateOldSetupController@getCompleted') ;
  }
  
  
}
