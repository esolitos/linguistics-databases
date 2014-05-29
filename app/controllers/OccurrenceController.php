<?php

class OccurrenceController extends \DoubleObjectController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
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
      
      if ( str_contains(Input::get('submit'), 'continue') ) {
        return Redirect::back()->withMessages(['Occurrence inserted successfully.']);
        
      } else {
        return Redirect::back()->withMessages(['I should now continue to the next point... But I am lazy']);
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
		//
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
      return Redirect::back()->withMessages(['Occurrence updated successfully.']);
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
		Occurrence::destroy($id);

    return Redirect::back()->withMessages(['Selected occurrence has been deleted.']);
	}


  public function defineObjectProperties($id)
  {
    $this->view_data['occurrence'] = Occurrence::find($id);
    
    return View::make('DoubleObject.Occurrence.properties', $this->view_data);
  }
  
  public function storeObjectProperties($id)
  {
    # code...
  }

}