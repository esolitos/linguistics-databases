<?php
/**
 * Query 1: Occorrenze in cui l'oggetto {IND|DIR} è in {1^|2^} posizione.
 * Query 2: Proprietà di entrambi gli oggetti delle occorrenze in cui il 2º oggetto ha una proprietà X
 * Query 3: Entrambi gli oggetti hanno la stessa proprietà/
 * Query 4: Numero di occorrenze per categoria quando entrambi gli oggetti hanno (o non hanno) una proprietà X
 * Query 5: Numero di apparizioni della proprietà X in prima negli oggetti in prima e seconda posizione
 *
 */

class QueryController extends \DoubleObjectBase {

  public function __construct()
  {
      $this->dataTableStyle = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css";
      $this->beforeFilter('csrf', array('on' => 'post'));

      parent::__construct();
  }


    /**
     * Checks if the user has access to this class.
     *
     * @return bool
     */
    protected function authorityControl()
    {
        return Authority::can(Permission::ACTION_R, 'Queries');
    }

  public function getIndex()
  {
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
    return Redirect::action('QueryController@getIndex')
      ->withMessages(['Query executed (I\'m joking!)']);
  }


  public function anyPropertyDistribution($verb=FALSE)
  {
    $this->view_data['page_title'] = 'Occurrences by Object Position';
    $this->view_data['page_description'] = 'In this page you can observe the distribution of the properties on the objects';

    $this->view_data['properties'] = ObjectProperty::allForSelect();
    $this->view_data['categories'] = OccurrenceCategory::allForSelect();
    $this->view_data['objectType'] = [
      'IND' => "Indirect",
      'DIR' => "Direct",
      'FIR' => "First",
      'SEC' => "Second",
    ];
    $this->view_data['selectedCategs'] = [];
    $this->view_data['selectedSpeakers'] = [];
    $this->view_data['objectClass'] = '';

    if ( $verb && strcasecmp('all', $verb) != 0 ) {
      $this->view_data['selectedVerb'] = $verb;
    }

    if ( Request::isMethod('POST') && Input::has('obj_type') )
    {
      $selectedProps = ObjectProperty::all()->lists('id');
      $selectedCategs = Input::get('categories');
      $selectedSpeakers = Input::get('speaker');

      $object['type'] = Input::get('obj_type');
      $object['key'] = 'type';

      if ( in_array($object['type'], ['FIR', 'SEC']) )
      {
        $object['key'] = 'position';
        $object['type'] = ($object['type'] === 'FIR') ? 1 : 2;
      }

      $distribution = [];
      foreach ($selectedProps as $propertyID) {
        $totals = Occurrence::groupBy('category_id');
        $query = Occurrence::whereHas('properties', function($query) use($propertyID, $object){
          $query->where($object['key'], '=', $object['type'])->where('property_id', '=', $propertyID);
        });

        if ( $verb ) {
          $query->where('verb', 'LIKE', $this->escapeLike($verb));
          $totals->where('verb', 'LIKE', $this->escapeLike($verb));
        }
        if ( !empty($selectedSpeakers) ) {
          $query->whereIn('speaker', (array)$selectedSpeakers);
          $totals->whereIn('speaker', (array)$selectedSpeakers);
        }

        if ( !empty($selectedCategs) ) {
          $query->whereIn('category_id', $selectedCategs);
          $totals->whereIn('category_id', $selectedCategs);
        }

        $query->groupBy('category_id')
          ->remember(60*24);

        $totals->remember(60*24)
          ->get(['category_id', DB::raw('COUNT(*) as count')])
          ->map(function($item) use(&$distribution) {
              $distribution['total'][$item->category_id] = $item->count;
          }
        );

        $query->get(['category_id', DB::raw('COUNT(*) as count')])
          ->map(function($item) use(&$distribution, $propertyID) {
            if ( $item->count ) {
              $percent = round(($item->count / $distribution['total'][$item->category_id]) *100, 1);

              $distribution[$item->category_id][$propertyID]['count'] = $item->count;
              $distribution[$item->category_id][$propertyID]['percent'] = $percent;
            } else {
              $distribution[$item->category_id][$propertyID] = FALSE;
            }
          }
        );
      }

      $this->view_data['distribution'] = $distribution;
      $this->view_data['selectedCategs'] = $selectedCategs;
      $this->view_data['selectedSpeakers'] = (array)$selectedSpeakers;
      $this->view_data['objectClass'] = Input::get('obj_type');
    }

    return $this->makeView('DoubleObject.Query.Statics.propertyDistribution');
  }

  public function getPropertyDistributionOccurrences()
  {
    $this->view_data['page_title'] = 'Occurrences by Object Position';
    $this->view_data['page_description'] = 'In this page you can observe the distribution of the properties on the objects';


    $this->view_data['properties'] = ObjectProperty::allForSelect();
    $this->view_data['categories'] = OccurrenceCategory::allForSelect();
    $this->view_data['selectedSpeakers'] = [];


    $selCategory  = Input::get('category');
    $selProperty  = Input::get('property');
    $selSpeakers  = (Input::get('speaker')) ? explode(',',Input::get('speaker')) : [];

    $selObjType   = Input::get('object');
    $selObjKey    = 'type';

    if ( in_array($selObjType, ['FIR', 'SEC']) )
    {
      $selObjKey = 'position';
      $selObjType = (strcasecmp($selObjType, 'FIR')==0) ? 1 : 2;
    }

    $query = Occurrence::where('category_id', '=' ,$selCategory);

    if ( $selProperty ) {
      $query->whereHas('properties', function ($query) use ($selProperty, $selObjKey, $selObjType) {
        $query->where($selObjKey, '=', $selObjType)
          ->where('property_id', '=', $selProperty);
      });
    }


    if ( !empty($selSpeakers) ) {
      $query->whereIn('speaker', $selSpeakers);
    }

    $this->view_data['occurrences'] = $query;
    $this->view_data['objectType'] = Input::get('object');

    return $this->makeView('DoubleObject.Query.Statics.propertyDistributionOccurrences');
  }

  /**
   * Routes the requests for the static queries
   */
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
      $object_pos = Input::get('obj_pos');
      $object_type = Input::get('obj_type');

      $objectIDs = CategoryObject::where('type', '=', $object_type)->remember(360)->lists('id');
      $categoryIDs = OccurrenceCategory::whereIn($object_pos.'_object_id', $objectIDs)->remember(360)->lists('id');

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
      $reverseSearch = Input::get('reverse');
      $propName = ObjectProperty::find($propertyID)->name;

      $op = empty($reverseSearch) ? '>=' : '<';
      $occurrences = Occurrence::with('properties')
        ->whereHas('properties', function($query) use($propertyID, $reverseSearch){
          $query->where('type', '=', 'IND')->where('property_id', '=', $propertyID);
        }, $op)
        ->whereHas('properties', function($query) use($propertyID, $reverseSearch){
          $query->where('type', '=', 'DIR')->where('property_id', '=', $propertyID);
        }, $op)
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

  public function escapeLike($str)
  {
    return str_replace(['%', '_'], ['\%', '\_'], $str);
  }
}
