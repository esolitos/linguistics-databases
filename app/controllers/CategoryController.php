<?php

class CategoryController extends \DoubleObjectBase {

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->dataTableStyle = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css";
    }

    /**
     * Display a listing of the resource.
     * GET /category
     *
     * @return Response
     */
    public function index()
    {
        $this->view_data['page_title'] = "Categories Management";
        $this->view_data['page_description'] = "In this page you can view, edit and delete the defined categories.";

        $this->view_data['can'] = (object) [
            'viewOccurrences' => Authority::can(Permission::ACTION_R, 'Occurrence'),
            'edit'            => Authority::can(Permission::ACTION_U, 'OccurrenceCategory'),
            'delete'          => Authority::can(Permission::ACTION_D, 'OccurrenceCategory'),
        ];

        $this->view_data['extra_scripts'][100] = "/javascript/category.datatables.js";

        return $this->withDataTables()->makeView('DoubleObject.Category.listing');
    }

  /**
   * Show the form for creating a new resource.
   * GET /category/create
   *
   * @return Response
   */
  public function create()
  {
    $this->view_data['page_title'] = "Create new Category";
    $this->view_data['page_description'] = "Here you can create a new category in terms of object definition, form, and case.<br>";
    $this->view_data['page_description'] .= "If none of the categories statisfies you needs just select 'New' and you'll be able to create a new object.";
    
    $this->view_data['objectTypes'] = CategoryObject::allForSelect();

    $this->view_data['extra_scripts'][100] = "/javascript/category.create.js";
    return $this->makeView('DoubleObject.Category.create');
  }
   
  /**
   * Store a newly created resource in storage.
   * POST /category
   *
   * @return Response
   */
  public function store()
  {
    $category = new OccurrenceCategory([
      'first_object_id' => Input::get('first_object_id'),
      'second_object_id' => Input::get('second_object_id'),
    ]);
    
    if ( str_contains(Input::get("first_object_id"), 'new') ) {
      
      $objNew = new CategoryObject();
      $objNew->type            = Input::get('obj1_type');
      $objNew->form            = Input::get('obj1_form');
      $objNew->declination     = Input::get('obj1_decl');
      $objNew->has_preposition = Input::get('obj1_prep', 0);
      
      if ($objNew->save()) {
        $category->first_object_id = $objNew->id;
      } else {
        $errors = [];
        foreach ($objNew->errors()->toArray() as $key => $value) {
          $errors['obj1_'.$key] = $value;
        }
        return Redirect::back()->withInput()->withErrors($errors);
      }
    }
    
    
    if ( str_contains(Input::get("second_object_id"), 'none') ) {
          $category->second_object_id = NULL;

    } else if ( str_contains(Input::get("second_object_id"), 'new') ) {
      $objNew = new CategoryObject();
      $objNew->type            = Input::get('obj2_type');
      $objNew->form            = Input::get('obj2_form');
      $objNew->declination     = Input::get('obj2_decl');
      $objNew->has_preposition = Input::get('obj2_prep', 0);
      
      if ( $objNew->save() ) {
        $category->second_object_id = $objNew->id;
        
      } else {
        $errors = [];
        foreach ($objNew->errors()->toArray() as $key => $value) {
          $errors['obj2_'.$key] = $value;
        }
        
        return Redirect::back()->withInput()->withErrors($errors);
      } 
    }
    
    $category->user_id = Auth::id();
    
    if ($category->save()) {
      $message = ["New Category created with success!"];
      
      if ( Input::get('submit-insert') ) {
        return Redirect::action('OccurrenceController@create')->withInput(['category_id'=>$category->id])->withMessages($message);
      } else {
        return Redirect::action('CategoryController@create')->withMessages($message);
      }
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
    
    return $this->makeView('DoubleObject.Category.show');
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
    $this->view_data['category'] = OccurrenceCategory::find($id);
    
    return $this->makeView('DoubleObject.Category.edit');
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
    $category = OccurrenceCategory::find($id);
    $category->forceEntityHydrationFromInput = true;
    
    if ( $category->save() ) {
      return Redirect::action('CategoryController@index')->with('messages', ['Category updated successfully.']);
    } else {
      return Redirect::back()->withInput()->withErrors( $category->errors() );
    }
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
    if ( Input::get('confirm', FALSE) ) {
      OccurrenceCategory::destroy($id);
      return Redirect::action('CategoryController@index')->withMessages(['Selected Category has been deleted.']);
      
    } else {
      $this->view_data['confirm'] = [
        'title' => "Removing Category: {$id}",
        'message' => "Are you sure to remove the Occurrence Category?",
        'path' => action('CategoryController@destroy', $id),
        'cancel-url' => URL::previous(),
      ];
      
      return $this->makeView('common.confirm');
    }
  }

}