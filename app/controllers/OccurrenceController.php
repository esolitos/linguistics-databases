<?php

class OccurrenceController extends \DoubleObjectController {

  private $propStorage = [
    'IND' => [],
    'DIR' => [],
  ];
  
  public function __construct()
  {
    parent::__construct();
    
    $this->view_data['allCategories'] = OccurrenceCategory::allForSelect();
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
    $this->view_data['occurrences'] = Occurrence::all();
    
    return View::make('DoubleObject.Occurrence.listing', $this->view_data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
    return View::make('DoubleObject.Occurrence.create', $this->view_data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{ 
    $occurrence = new Occurrence();
    
    if ( $occurrence->save() ) {
      
      if ( Input::has('set-properties') ) {
        return Redirect::action('OccurrenceController@defineObjectProperties', $occurrence->id);
        
      } else {
        return Redirect::back()->withMessages(['Occurrence inserted successfully.']);
      }
      
    } else {
      return Redirect::back()->withInput()->withErrors( $occurrence->errors() );
    }
	}

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    return View::make('DoubleObject.Occurrence.show', $this->view_data);
  }
  
  
  public function getBy($filter, $value)
  {
    $this->view_data['occurrences'] = Occurrence::where($filter, '=', $value)->get();
    $this->view_data['condition'] = (object) [ 'filter' => $filter, 'value' => $value ];

    return View::make('DoubleObject.Occurrence.listing', $this->view_data);
  }
  
  public function getByCategory($category)
  {
    $this->view_data['occurrences'] = Occurrence::where('category_id', '=', $category)->get();
    $this->view_data['condition'] = (object) [ 'filter' => 'Category', 'value' => OccurrenceCategory::allForSelect()[$category] ];

    return View::make('DoubleObject.Occurrence.listing', $this->view_data);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    return View::make('DoubleObject.Occurrence.edit', $this->view_data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
    $occurrence = Occurrence::find($id);
    $occurrence->forceEntityHydrationFromInput = true;
    
    if ( $occurrence->save() ) {
      return Redirect::action('OccurrenceController@show', $id)->withMessages(['Occurrence updated successfully.']);
    } else {
      return Redirect::back()->withInput()->withErrors( $occurrence->errors() );
    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
    if ( Input::get('confirm', FALSE) ) {
      Occurrence::destroy($id);
      return Redirect::action('OccurrenceController@index')->withMessages(['Selected occurrence has been deleted.']);
      
    } else {
      $this->view_data['confirm'] = [
        'title' => "Removing Occurrence: {$id}",
        'message' => "Are you sure to remove the occurrence?",
        'path' => action('OccurrenceController@destroy', $id),
        'cancel-url' => URL::previous(),
      ];
      
      return View::make('common.confirm', $this->view_data);
    }
	}


  public function defineObjectProperties($id)
  {
    if ( OccurrenceObjectProperty::where('occurrence_id', '=', $id)->count() != 0 ) {
      return Redirect::action('OccurrenceController@editObjectProperties', $id)->withMessages(["Properties already defined, edit properties instead."]);
    }
    
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    return View::make('DoubleObject.Occurrence.properties', $this->view_data);
  }
  
  public function storeObjectProperties($id)
  {
    if ( OccurrenceObjectProperty::where('occurrence_id', '=', $id)->count() != 0 ) {
      return Redirect::action('OccurrenceController@editObjectProperties', $id)->withMessages(["Properties already defined, edit properties instead."]);
    }
    
    $this->insertProperties( Input::get('indirect_properties', []), 'IND' );
    $this->insertProperties( Input::get('direct_properties', []), 'DIR' );
    $num_properties = $this->storeProperties($id);
    
    return Redirect::action('OccurrenceController@show', $id)->withMessages(["Defined {$num_properties} properties for the Occurrence's Objects!"]);
  }
  
  public function editObjectProperties($id)
  {
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    $this->view_data['indirect_properties'] = array_flatten($this->view_data['occurrence']->properties('IND')->get(['property_id'])->toArray());
    $this->view_data['direct_properties'] = array_flatten($this->view_data['occurrence']->properties('DIR')->get(['property_id'])->toArray());
    
    return View::make('DoubleObject.Occurrence.edit-properties', $this->view_data);
  }
  
  public function updateObjectProperties($id)
  {
    $this->insertProperties( Input::get('indirect_properties', []), 'IND' );
    $this->insertProperties( Input::get('direct_properties', []), 'DIR' );
    $this->storeProperties($id);

    $removed_prop['IND'] = array_diff( Occurrence::find($id)->propertyIDs('IND'), Input::get('indirect_properties', []) );
    $removed_prop['DIR'] = array_diff( Occurrence::find($id)->propertyIDs('DIR'), Input::get('direct_properties', []) );
    
    foreach ($removed_prop as $property_type => $property_list) {
      if ( !empty($property_list) ) {
        OccurrenceObjectProperty::where('occurrence_id', '=', $id)
          ->where('type', '=',$property_type)
          ->whereIn('property_id', $property_list)
          ->delete();
      }
    }
    
    return Redirect::action('OccurrenceController@show', $id)->withMessages(["Object's Properties updated for this occurrence!"]);
  }
  
  
  private function insertProperties($proderty_ids, $type)
  {
    return $this->propStorage[$type] += $proderty_ids;
  }
  
  private function removeProperties($proderty_ids, $type)
  {
    return $this->propStorage[$type] = array_diff($this->propStorage[$type], $proderty_ids);
  }
  
  private function storeProperties($occurrence)
  {
    $property_rows = [];
    foreach ($this->propStorage as $prop_type => $properties) {
      $properties = array_diff( array_unique($properties, SORT_NUMERIC), Occurrence::find($occurrence)->propertyIDs($prop_type));
      foreach($properties as $pid) {
        $property_rows[] = [
          'occurrence_id' => $occurrence,
          'type'          => $prop_type,
          'property_id'   => $pid,
        ];
      }
    }
    
    if ( ! empty($property_rows) ) {
      OccurrenceObjectProperty::insert($property_rows);
    }
    
    return count($property_rows);
  }

}