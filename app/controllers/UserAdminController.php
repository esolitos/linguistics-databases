<?php

class UserAdminController extends \BaseController {

  public function __construct()
  {
    parent::__construct();
    
    $this->dataTableStyle = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css";
  }
  
  /**
   * Display a listing of the resource.
   * GET /user/admin
   *
   * @return Response
   */
  public function index()
  {
    $this->view_data['page_title'] = "User List";
    $this->view_data['page_description'] = "In this page you see all the users and you can manage them.";
    
    $this->view_data['users'] = User::all();
    
    $this->view_data['extra_scripts'][100] = "/javascript/useradmin.datatables.js";
    return $this->withDataTables()->makeView('user.listing');
  }

  /**
   * Show the form for creating a new resource.
   * GET /user/admin/create
   *
   * @return Response
   */
  public function create()
  {
    $this->view_data['page_title'] = "Create new User";
    $this->view_data['page_description'] = "In this page you can create a new user.";
    
    $this->view_data['create'] = TRUE;
    $this->view_data['admin_edit'] = FALSE;
    $this->view_data['user'] = new User();
    
    return $this->makeView('user.edit');
  }

  /**
   * Store a newly created resource in storage.
   * POST /user/admin
   *
   * @return Response
   */
  public function store()
  {
    // $user = new User(Input::all());
    $user = new User;
    
    $user->addPasswordRules();
    $user->autoHydrateEntityFromInput = true;
    
    // $user->pasword = Input::get('password');
    // $user->password_confirmation = Input::get('password_confirmation');
    
    if ( $user->save() ) {
      return Redirect::action('UserAdminController@index')->withMessages(['User updated successfully.']);
    } else {
      return Redirect::back()->withInput()->withErrors( $user->errors() );
    }
  }

  /**
   * Display the specified resource.
   * GET /user/admin/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $this->view_data['page_title'] = "User Profile";
    // $this->view_data['page_description'] = "In this page you see all the users and you can manage them.";
    
    $this->view_data['user'] = User::find($id);
    
    return $this->makeView('user.show');
  }

  /**
   * Show the form for editing the specified resource.
   * GET /user/admin/{id}/edit
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    if ( $id < 2 ) {
      return Redirect::action('UserAdminController@index')->withMessages(['ERROR: Editing administrative users is not allowed!']);
    }
    $this->view_data['page_title'] = "Update User Profile";
    $this->view_data['page_description'] = "Here you can update user's information for the chosen user.";
    
    $this->view_data['create'] = FALSE;
    $this->view_data['admin_edit'] = TRUE;
    $this->view_data['user'] = User::find($id);
    
    return $this->makeView('user.edit');
  }

  /**
   * Update the specified resource in storage.
   * PUT /user/admin/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    $user = User::find($id);
    $user->forceEntityHydrationFromInput = true;
    
    if ( $user->updateUniques() ) {
      return Redirect::action('UserAdminController@index')->withMessages(['User updated successfully.']);
    } else {
      return Redirect::back()->withInput()->withErrors( $user->errors() );
    }
  }

  /**
   * Remove the specified resource from storage.
   * DELETE /user/admin/{id}
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }

}