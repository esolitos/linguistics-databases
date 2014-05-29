<?php

class ObjectPropertyController extends \DoubleObjectController {

	/**
	 * Display a listing of the resource.
	 * GET /object-property
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('DoubleObject.ObjectProperty.listing', $this->view_data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /object-property/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('DoubleObject.ObjectProperty.create', $this->view_data);
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
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /object-property/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
    $this->view_data['property'] = ObjectProperty::find($id);
    
		return View::make('DoubleObject.ObjectProperty.edit', $this->view_data);
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
    try {
      ObjectProperty::destroy($id);
      
    } catch (PDOException $e) {
      if( $e->getCode() == 23000 ){
        Redirect::back()->withMessages(['Property used by some objects: delete is not allowed!']);
      } else {
        Redirect::back()->withMessages(['Generic Error: '.$e->getMessage()]);
      }
    }

    return Redirect::back();
	}

}