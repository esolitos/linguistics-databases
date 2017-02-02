<?php

class ObjectPropertyController extends \DoubleObjectBase {

  public function __construct()
  {
    parent::__construct();
    
    $this->dataTableStyle = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css";
  }
  
  /**
   * Display a listing of the resource.
   * GET /object-property
   *
   * @return Response
   */
  public function index()
  {
    $this->view_data['page_title'] = "Object Properties Management";
    $this->view_data['page_description'] = "In this page you can view, edit and delete the already created properties.";
    
    $this->view_data['extra_scripts'][100] = "/javascript/object.property.datatables.js";
    return $this->withDataTables()->makeView('DoubleObject.ObjectProperty.listing');
  }

  /**
  * Show the form for creating a new resource.
  * GET /object-property/create
  *
  * @return Response
  */
  public function create()
  {
    $this->view_data['page_title'] = "Create new Object Property";
    $this->view_data['page_description'] = "Add a name of a new property you want to add.";
    
    return $this->makeView('DoubleObject.ObjectProperty.create');
  }

  /**
  * Store a newly created resource in storage.
  * POST /object-property
  *
  * @return Response
  */
  public function store()
  {
    $prop = new ObjectProperty();
    
    if ( $prop->save() ) {
      return Redirect::back()->with('messages', ['Object Property created successfully.']);
    } else {
      return Redirect::back()->withInput()->withErrors( $prop->errors() );
    }
  }

  /**
  * Display the specified resource.
  * GET /object-property/{id}
  *
  * @param  int  $id
  * @return Response
  */
  // public function show($id)
  // {
  //   // NOT USED
  // }

  /**
  * Show the form for editing the specified resource.
  * GET /object-property/{id}/edit
  *
  * @param  int  $id
  * @return Response
  */
  public function edit($id)
  {
    $this->view_data['page_title'] = "Edit Object Property";
    $this->view_data['page_description'] = "Set the new name of the property you want to modify.";
    
    $this->view_data['property'] = ObjectProperty::find($id);
    
    return $this->makeView('DoubleObject.ObjectProperty.edit');
  }

  /**
  * Update the specified resource in storage.
  * PUT /object-property/{id}
  *
  * @param  int  $id
  * @return Response
  */
  public function update($id)
  {
    $prop = ObjectProperty::find($id);
    $prop->forceEntityHydrationFromInput = true;
    
    if ( $prop->save() ) {
      return Redirect::action('ObjectPropertyController@index')->with('messages', ['Object Property updated successfully.']);
    } else {
      return Redirect::back()->withInput()->withErrors( $prop->errors() );
    }
  }

  /**
  * Remove the specified resource from storage.
  * DELETE /object-property/{id}
  *
  * @param  int  $id
  * @return Response
  */
  public function destroy($id)
  {
    if ( Input::get('confirm', FALSE) ) {
      ObjectProperty::destroy($id);
      return Redirect::action('CategoryController@index')->withMessages(['Selected Category has been deleted.']);
      
    } else {
      $this->view_data['confirm'] = [
        'title' => "Property Data",
        'message' => "You are deleting the property: <strong>".ucfirst(ObjectProperty::find($id)->name)."</strong>",
        'path' => action('ObjectPropertyController@destroy', $id),
        'cancel-url' => URL::previous(),
      ];
      
      $this->view_data['page_title'] = "Delete Object Property";
      $this->view_data['page_description'] = "Are you sure to remove the Property? It will be <strong>permanently</strong> removed also from all the Objects!";
      
      
      return $this->makeView('common.confirm');
    }

    return Redirect::back();
  }

}