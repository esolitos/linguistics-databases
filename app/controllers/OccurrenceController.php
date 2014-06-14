<?php

class OccurrenceController extends \DoubleObjectController {

  private $propStorage = [
    'IND' => [],
    'DIR' => [],
  ];
  
  public function __construct()
  {
    parent::__construct();

    $this->dataTableStyle = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css";    
    $this->view_data['allCategories'] = OccurrenceCategory::allForSelect();
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $this->view_data['page_title'] = "All Occurrences";
    $this->view_data['page_description'] = "All the existing Occurrences are listed in this page. You can sort and filter the contend based on your requirements<br>";
    $this->view_data['page_description'] .= "<b>Note:</b> You can also search not hidden filesd such as <em>Speaker (Adult/Child)</em> or <em>Keyword</em>";

    
    $this->view_data['occurrences'] = Occurrence::all();

    $this->view_data['extra_scripts'][100] = "/javascript/occurrence.datatables-category-filter.js";
    return $this->withDataTables()->makeView('DoubleObject.Occurrence.listing');
	}

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $this->view_data['page_title'] = "Insert new Occurrence";
    $this->view_data['page_description'] = "Here you can insert a new Occurrence. Please fill all the required fields.<br>";
    $this->view_data['page_description'] .= "You can chose to define object's properties right after the insert clicking on <em>Save and define properties</em>";
    
    
    $this->view_data['occurrence'] = new Occurrence();
    $this->view_data['create'] = TRUE;
    
    return $this->makeView('DoubleObject.Occurrence.edit');
  }
   
  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  { 
    $occurrence = new Occurrence( Input::all() );
    
    $occurrence->user_id = Auth::id();
    
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
    
    return $this->makeView('DoubleObject.Occurrence.show');
  }
  
  
  public function getBy($filter, $value)
  {
    $this->view_data['occurrences'] = Occurrence::where($filter, '=', $value)->get();
    $this->view_data['condition'] = (object) [ 'filter' => $filter, 'value' => $value ];

    $this->view_data['extra_scripts'][100] = "/javascript/occurrence.datatables-category-filter.js";
    return $this->withDataTables()->makeView('DoubleObject.Occurrence.listing');
  }
  
  public function getByCategory($category)
  {
    $this->view_data['occurrences'] = Occurrence::where('category_id', '=', $category)->get();
    $this->view_data['condition'] = (object) [ 'filter' => 'Category', 'value' => OccurrenceCategory::allForSelect()[$category] ];

    $this->view_data['extra_scripts'][100] = "/javascript/occurrence.datatables-category-filter.js";
    return $this->withDataTables()->makeView('DoubleObject.Occurrence.listing');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $this->view_data['page_title'] = "Edit Occurrence";
    $this->view_data['page_description'] = "In this page you can modify an existing Occurrence. Please fill all the required fields.<br>";
    $this->view_data['page_description'] .= "<small>Editing Occurrence: {$id}</small>";

    $this->view_data['create'] = FALSE;
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    return $this->makeView('DoubleObject.Occurrence.edit');
	}

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $this->view_data['back_url'] = (Input::get('back_url')) ? Input::get('back_url') : URL::previous() ;
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
        'title' => "Please Confirm",
        'message' => "Are you sure to remove the occurrence {$id}?",
        'path' => action('OccurrenceController@destroy', $id),
        'cancel-url' => URL::previous(),
      ];
      $this->view_data['page_title'] = "Delete Occurrence";
      $this->view_data['page_description'] = "Are you sure to remove this Occurrence? In the future it will be possible to restore it, but be careful.";
      
      return $this->makeView('common.confirm');
    }
	}

  public function editObjectProperties($id)
  {
    $this->view_data['page_title'] = "Define Object Properties";
    $this->view_data['page_description'] = "Are you sure to remove this Occurrence? In the future it will be possible to restore it, but be careful.";
    
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    $this->view_data['indirect_properties'] = array_flatten($this->view_data['occurrence']->properties('IND')->get(['property_id'])->toArray());
    $this->view_data['direct_properties'] = array_flatten($this->view_data['occurrence']->properties('DIR')->get(['property_id'])->toArray());
    
    return $this->makeView('DoubleObject.Occurrence.edit-properties');
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