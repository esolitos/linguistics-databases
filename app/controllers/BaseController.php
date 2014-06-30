<?php

use Illuminate\Support\MessageBag as Messages;

class BaseController extends Controller {

  protected $view_data = [];
  protected $layout = NULL;
  
  public $dataTableStyle = '';

  function __construct()
  {
    $this->view_data['messages'] = new Messages( [ 'general' => Session::get('messages', []) ] );

    $this->view_data['body_attributes'] = [];

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
            return "<span class='error'>$msg</span>";
        }
        return '';
    });
    
    Form::macro('label_item_error', function($type, $name, $label, $value, $errors, $options = [] ){
      $error_class = ($errors->has($name)) ? 'error' : '';
      $id = (empty($options['id'])) ? $name : $options['id'];
      $options['id'] = $id;
      
      $html = "<label class='{$error_class}' for='{$id}'>";
      
      switch ($type) {
        case 'raw':
          $html .= $label;
          $html .= $value;
          break;
        
        case 'text':
          $html .= $label;
          $html .= Form::text($name, $value, $options);
          break;

        case 'checkbox':
          $checked = (isset($options['checked']) && $options['checked'] == TRUE);
          
          $html .= Form::checkbox($name, $value, $checked, $options);
          $html .= " {$label}";
          break;
        
        default:
          $options['type'] = $type;
          $html .= $label;
          $html .= Form::text($name, $value, $options);
          break;
      }

      if ($error_class != '') {
        $html .= "<small class='error'>{$errors->first($name)}</small>";
      }
      
      return $html.'</label>';
    });
    
    Form::macro('label_select_error', function($name, $label, $value_list, $errors, $selected = null, $options = [] ){
      if (empty($options['id'])) {
        $options['id'] = $name;
      }
      
      return Form::label_item_error('raw', $name, $label, Form::select($name, $value_list, $selected, $options), $errors);
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
      ->add( '#' , 'User', $user_options, [], ['class' => "user-links has-dropdown"] );
    
    
    
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
  
  protected function withDataTables($style='')
  {
    $this->view_data['extra_scripts'][] = "//cdn.datatables.net/1.10.0/js/jquery.dataTables.min.js";
    $this->view_data['extra_scripts'][] = "//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.js";
    
    if ( !empty( $this->dataTableStyle ) ) {
      $this->view_data['extra_style'][] = $this->dataTableStyle;
    } else {
      $this->view_data['extra_style'][] = "//cdn.datatables.net/1.10.0/css/jquery.dataTables.css";
    }
    
    return $this;
  }

}
