<?php

class UserController extends \BaseController {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
   public function index()
  {
    if ( Auth::check() )
    {
      return Redirect::route("user.profile");
    }

    $this->view_data['page_title'] = "User Login";
    
    return $this->makeView('user.login');
  }
	
  /**
   * Validates the login and redirects to the profile page
   * 
   * @return Response
   */
  public function login()
  {
    $validator = $this->getLoginValidator();

    if ( $validator->passes() )
    {
      if (Auth::attempt( $this->getLoginCredentials(), TRUE ))
      {
        return Redirect::route("user.profile");
      }
  
      return Redirect::back()->withInput()->withErrors([ "password" => ["Credentials invalid."] ]);
    }
    else {
      return Redirect::back()->withInput()->withErrors($validator);
    }
  }
	
  /**
   * Sign out user and redirects to the login page
   * 
   * @return Response
   */
  public function logout()
  {
    Auth::logout();

    return Redirect::route("user.login")->withMessages(["You have signed out successfully. Goodbye!"]);
  }
	
  public function showProfile()
  {
    $this->view_data['page_title'] = "User Profile";
    return $this->makeView('user.profile');
  }

  public function signUp()
  {
    return Redirect::route("user.login")->withMessages(["Sign Up currently not Allowed! To continue please login."]);
  }
  
  public function register()
  {
    return "Register";
    // return $this->makeView('user.login');
  }

	
  protected function getLoginValidator()
  {
    return Validator::make(Input::all(), [
      "username" => "required",
      "password" => "required",
      ]
    );
  }
	
  protected function getLoginCredentials()
  {
    return [
      "username" => Input::get("username"),
      "password" => Input::get("password")
    ];
  }
}