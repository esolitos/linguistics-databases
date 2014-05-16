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
			return Redirect::route("user/profile");
		}
		
		return View::make("user/login", $this->view_data);
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
				return Redirect::route("user/profile");
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
		$messages = Session::get('messages', []);
		$messages[] = "You have signed out successfully. Goodbye!";
		
		Session::flash('messages', $messages);
		return Redirect::route("user/login");
	}
	
	public function showProfile()
	{
		return View::make("user/profile", $this->view_data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
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
		//
	}

	/**
	 * Update the specified resource in storage.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
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