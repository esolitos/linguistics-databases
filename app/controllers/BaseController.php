<?php

use Illuminate\Support\MessageBag as Messages;

class BaseController extends Controller {
	
	protected $view_data = [];
	
	function __construct()
	{
		$this->view_data['messages'] = new Messages( [ 'general' => Session::get('messages', []) ] );
		
		$this->view_data['body_attributes'] = [];
	}
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
