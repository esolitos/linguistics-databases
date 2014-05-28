<?php

class CategoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /category
	 *
	 * @return Response
	 */
	public function index()
	{
    return View::make('DoubleObject.Category.listing', $this->view_data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /category/create
	 *
	 * @return Response
	 */
	public function create()
	{
    $this->view_data['objectTypes'] = CategoryObject::allForSelect();
    
    return View::make('DoubleObject.Category.create', $this->view_data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /category
	 *
	 * @return Response
	 */
	public function store()
	{
    $category = new OccurrenceCategory();
    
    if ( Input::get("first_object") == 'new' ) {
      
      $objNew = new CategoryObject();
      $objNew->type            = Input::get('obj1_type');
      $objNew->form            = Input::get('obj1_form');
      $objNew->declination     = Input::get('obj1_decl');
      $objNew->has_preposition = Input::get('obj1_prep', 0);
      
      if ($objNew->save()) {
        $category->first_object = $objNew->id;
      } else {
        $errors = [];
        foreach ($objNew->errors()->toArray() as $key => $value) {
          $errors['obj1_'.$key] = $value;
        }
        return Redirect::back()->withInput()->withErrors($errors);
      }
    }
    
    if ( Input::get("second_object") == 'none' ) {
          $category->second_object = NULL;

    } else if ( Input::get("second_object") == 'new' ) {
      $objNew = new CategoryObject();
      $objNew->type            = Input::get('obj2_type');
      $objNew->form            = Input::get('obj2_form');
      $objNew->declination     = Input::get('obj2_decl');
      $objNew->has_preposition = Input::get('obj2_prep', 0);
      
      if ($objNew->save()) {
        $category->first_object = $objNew->id;
      } else {
        $errors = [];
        foreach ($objNew->errors()->toArray() as $key => $value) {
          $errors['obj2_'.$key] = $value;
        }
        return Redirect::back()->withInput()->withErrors($errors);
      } 
    }
    
    
    if ($category->save()) {
      return Redirect::action('CategoryController@index');
    } else {
      return Redirect::back()->withInput()->withErrors($category->errors());
    }
	}

	/**
	 * Display the specified resource.
	 * GET /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
    $this->view_data['category'] = OccurrenceCategory::with('firstObj', 'secondObj')->find($id);
    
		return View::make('DoubleObject.Category.show', $this->view_data);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /category/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
    $this->view_data['category'] = OccurrenceCategory::with('firstObj', 'secondObj')->find($id);
    
		return View::make('DoubleObject.Category.edit', $this->view_data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		OccurrenceCategory::destroy($id);

    return Redirect::action('CategoryController@index');
	}

}