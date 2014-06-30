<?php
/**
 * Query 1: Occorrenze in cui l'oggetto {IND|DIR} è in {1^|2^} posizione.
 * Query 2: Proprietà di entrambi gli oggetti delle occorrenze in cui il 2º oggetto ha una proprietà X 
 * Query 3: Entrambi gli oggetti hanno la stessa proprietà/
 * Query 4: Numero di occorrenze per categoria quando entrambi gli oggetti hanno (o non hanno) una proprietà X
 * Query 5: Numero di apparizioni della proprietà X in prima negli oggetti in prima e seconda posizione
 * 
 */

class QueryController extends \DoubleObjectController {

  public function __construct()
  {
    $this->dataTableStyle = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css";
    $this->beforeFilter('csrf', array('on' => 'post'));
    
    parent::__construct();
  }
  
  public function getIndex()
  {
    $this->view_data['executed_queries'] = Redis::get('tot_queries');
    
    return $this->makeView('DoubleObject.Query.index');
  }
  
  public function getBuild()
  {
    $this->view_data['extra_scripts'][] = "/javascript/jquery.query-builder.js";
    
    return $this->makeView('DoubleObject.Query.build');
  }

  
  public function postVerify()
  {
    if ( Input::ajax() ) {
      $query_structure = Input::get('query_structure');
      /**
       * If we're reciving a string try to decode it into a php object
       */
      if ( is_string($query_structure) ) {
        $query_structure = json_decode( $query_structure );
      
        if (  json_last_error() !== JSON_ERROR_NONE ) {
          return $this->returnAjaxError('Data', 'Server Error, please reload the page and rebuild the query.');
        }
      }
      
      // Empty query structure is empty. Something is not right!
      if ( empty($query_structure) ) {
        return $this->returnAjaxError('Query Structure', 'The query is empty. Please reload the page and rebuild the query.');
      }
      
      // Le'ts validate the selected output structure.
      if ( ! $this->isValidOutputSetup($query_structure)) {
        return $this->returnAjaxError('Query Output Structure', 'You have not selected an output object and/or an output style!');
      }
      
      
      return Response::json( $query_structure );
    }
    else {
      return Redirect::action('QueryController@getIndex');
    }
  }
  
  public function postExecute()
  {
    // Verify that the query makes sense!
    
    Redis::incr('tot_queries');
    return Redirect::action('QueryController@getIndex')
      ->withMessages(['Query executed (I\'m joking!)']);
  }
  
  public function anyStatic($query_id)
  {
    switch ($query_id) {
      case 1:
      case 'objects-position':
        return $this->objPosition();
      
      case 2:
      case 'related-properties':
        return $this->relatedProperties();
      
      case 3:
      case 'same-property':
        return $this->sameProperties();
      
      default:
        # error
        break;
    }
  }
  
  
  /*
   * -------- --------  STATIC QUERIES -------- -------- 
   */
  
  /**
   * Static Query 1:
   * Occorrenze in cui l'oggetto {IND|DIR} è in {1^|2^} posizione.
   *
   */
  protected function objPosition()
  {
    $this->view_data['page_title'] = 'Occurrences by Object Position';
    $this->view_data['page_description'] = 'This query selects all the occurrences in which the direct/ indirect object is in the 1st/2nd position';
    
    if ( Request::isMethod('GET') || !(Input::has('obj_type') && Input::has('obj_pos')) ) {
      return $this->makeView('DoubleObject.Query.Statics.objPosition');
    }
    else {
      Redis::incr('tot_queries');
      $object_pos = Input::get('obj_pos');
      $object_type = Input::get('obj_type');
      
      $objectIDs = CategoryObject::remember(360)->where('type', '=', $object_type)->lists('id');
      $categoryIDs = OccurrenceCategory::remember(360)->whereIn($object_pos.'_object_id', $objectIDs)->lists('id');
      
      $this->view_data['page_description'] = "Occurrences in which the <strong>{$object_type}</strong> object is in the <strong>{$object_pos}</strong> position";
      
      $this->view_data['occurrences'] = Occurrence::remember(360)->whereIn('category_id', $categoryIDs)->get();
      $this->view_data['allCategories'] = OccurrenceCategory::allForSelect();
      $this->view_data['extra_scripts'][100] = "/javascript/occurrence.datatables-category-filter.js";
      return $this->withDataTables()->makeView('DoubleObject.Occurrence.listing');
    }
  }


  /**
   * Query 2:
   * Frequenza di ogni Proprietà (per oggetto) gli oggetti delle occorrenze in cui il 2º oggetto ha una proprietà X 
   * 
   * TODO: Per eseguire questa query senza impazzire va aggiunto il campo "Posizione" nella tabella di salvataggio delle "OccurrenceObjectProperty"
   */
  public function relatedProperties()
  {
    $this->view_data['page_title'] = 'Related Properties';
    $this->view_data['page_description'] = 'This query selects all the properties that are found in an Occurrence where the 2<sup>nd</sup> object shows a selected property.';
    $this->view_data['related_source'] = NULL;
    
    if ( Request::isMethod('GET') || !Input::has('property') ) {
      return $this->makeView('DoubleObject.Query.Statics.relatedProperties');
    }
    else {
      $propertyID = Input::get('property');
      $occurrenceIDs = OccurrenceObjectProperty::distinct()
        ->where('position', '=', 2)
          ->where('property_id', '=', $propertyID)
            ->lists('occurrence_id');
      
      $first = [];
      OccurrenceObjectProperty::where('position', '=', 1)
        ->whereIn('occurrence_id', $occurrenceIDs)->groupBy('property_id')
          ->get(['property_id', DB::raw('COUNT(*) as count')])
          ->map(function($item) use(&$first) {
            $first[$item->property_id] = $item->count;
          });
      
      $second = [];
      OccurrenceObjectProperty::where('position', '=', 2)
        ->whereIn('occurrence_id', $occurrenceIDs)->groupBy('property_id')
          ->get(['property_id', DB::raw('COUNT(*) as count')])
            ->map(function($item) use(&$second) {
              $second[$item->property_id] = $item->count;
            });

      $this->view_data['related'] = [
        'first' => $first,
        'second' => $second,
      ];
      
      $prop_list = [];
      ObjectProperty::all()->map(function($item) use(&$prop_list) {
          $prop_list[$item->id] = $item->name;
      });
      
      $this->view_data['property_IDs'] = $prop_list;
      $this->view_data['related_source'] = ucwords($prop_list[$propertyID]);
      $this->view_data['extra_scripts'][100] = "/javascript/occurrence.datatables-category-filter.js";
      return $this->withDataTables()->makeView('DoubleObject.Query.Statics.relatedProperties');
    }
  }
  
  public function sameProperties()
  {
    $this->view_data['page_title'] = 'Same Properties';
    
    if ( Request::isMethod('GET') || !Input::has('property') ) {
      $this->view_data['page_description'] = 'This query shows all the properties that are found having a common property on both first and second object';
      return $this->makeView('DoubleObject.Query.Statics.sameProperties');
    }
    else {
      $propertyID = Input::get('property');
      $propName = ObjectProperty::find($propertyID)->name;
      
      $occurrences = Occurrence::with('properties')
        ->whereHas('properties', function($query) use($propertyID){
          $query->where('type', '=', 'IND')->where('property_id', '=', $propertyID);
        })
        ->whereHas('properties', function($query) use($propertyID){
          $query->where('type', '=', 'DIR')->where('property_id', '=', $propertyID);
        })
        ->get();
        
      $this->view_data['occurrences'] = $occurrences;
      $this->view_data['allCategories'] = OccurrenceCategory::allForSelect();
      $this->view_data['extra_scripts'][100] = "/javascript/occurrence.datatables-category-filter.js";
      
      $this->view_data['page_description'] = 'You are viewing the Occurrences which have <strong>'.$propName.'</strong> property on both direct and indirect object';
      return $this->withDataTables()->makeView('DoubleObject.Occurrence.listing');
    }
  }
  
  /*
   * -------- --------  PRIVATE FUNCTIONS -------- -------- 
   */
  
  
  private static function isValidOutputSetup($queryStruct)
  {
    if ( isset($queryStruct->output)
     && isset($queryStruct->output->object)
     && isset($queryStruct->output->type) ) {
        
      switch ($queryStruct->output->object) {
        case 'CAT':
        case 'OCC':
        case 'PROP':
        // Those choiches are good, so le'ts continue.
        break;
        
        default:
        return FALSE;
      }
      
      switch ($queryStruct->output->type) {
        case 'ALL':
        case 'NAME':
        case 'COUNT':
        // Those choiches are good, so le'ts continue.
        break;
        
        default:
        return FALSE;
      }
      
      // At this point we know that both OutObj and OutType are correct!
      return TRUE;
    }
    
    return FALSE;
  }
}