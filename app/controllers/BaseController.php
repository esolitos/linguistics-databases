<?php

use Illuminate\Support\MessageBag as Messages;

class BaseController extends Controller {

  protected $view_data = [];
  protected $layout = NULL;

  function __construct()
  {
    $this->view_data['messages'] = new Messages( [ 'general' => Session::get('messages', []) ] );

    $this->view_data['body_attributes'] = [];

    Menu::handler('top-menu-right', array('class' => 'right'));
    Menu::handler('top-menu-left', array('class' => 'left'));
    
    if ( Auth::check() ) {
      $user_options = Menu::items(null, ['class' => "dropdown"])
        ->add( route('user.profile') , 'Profile')
        ->add( route('user.logout') , 'Sign Out');
    } else {
      $user_options = Menu::items(null, ['class' => "dropdown"])
        ->add( route('user.login') , 'Sign In')
        ->add( route('user.register') , 'Sign Up');
    }
    Menu::handler('top-menu-right')
      ->add( action('StatisticsController@getIndex') , 'User', $user_options, [], ['class' => "user-links has-dropdown"] );
    
    
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
            return "<small class='error'>$msg</small>";
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
  
  
  protected function makeView($customLayout = NULL)
  {
    if ( !empty($customLayout) ) {
      return View::make($customLayout, $this->view_data);;
    }
    elseif ( !empty($this->layout) ) {
      return View::make($this->layout, $this->view_data);;
    }
    else {
      Log::error('The template is not specified. Unable to render a view!');
      
    }
  }

}
