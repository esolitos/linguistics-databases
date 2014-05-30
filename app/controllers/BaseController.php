<?php

use Illuminate\Support\MessageBag as Messages;

class BaseController extends Controller {
	
	protected $view_data = [];
	
	function __construct()
	{
		$this->view_data['messages'] = new Messages( [ 'general' => Session::get('messages', []) ] );
		
		$this->view_data['body_attributes'] = [ 'class'=>'has-top-bar' ];

    Menu::handler('top-menu-right', array('class' => 'right'));
    Menu::handler('top-menu-left', array('class' => 'left'));
    
    
    Form::macro('form_checkbox', function($name, $value, $label, $checked = null, $options = array())
    {
      $id = $name;
      if ( empty($options['id']) ) {
        $options['id'] = $name;
      } else {
        $id = $options['id'];
      }
      
      return '<label for="'.$id.'">'.Form::checkbox($name, $value, $checked, $options).' '.$label.'</label>';
    });
    
    Form::macro('field_error', function($field, $errors){
        if($errors->has($field)){
            $msg = $errors->first($field);
            return "<span class=\"error\">$msg</span>";
        }
        return '';
    });
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
