<?php

use Illuminate\Routing\Controller;
use Illuminate\Support\MessageBag as Messages;
use Menu\Menu;

class BaseController extends Controller {

  protected $view_data = [];
  protected $layout = NULL;
  
  public $dataTableStyle = '';


    function __construct()
    {
        $action = last(explode('@', $this->getFilterer()->current()->getActionName()));
        if (method_exists($this, 'authorityControl')) {
            $hasAccess = $this->authorityControl($action);
        }
        else {
            $action = $this->normalizeResourceCrudAction($action);

            $hasAccess = Authority::can($action, __CLASS__);
        }
        if ( ! $hasAccess) {
            App::abort(403);
        }

        $this->view_data['messages'] = new Messages([ 'general' => Session::get('messages', []) ]);

        $this->view_data['body_attributes'] = [];

        Menu::handler('top-menu-right', [ 'class' => 'right' ]);
        Menu::handler('top-menu-left', [ 'class' => 'left' ]);
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

    if ( Authority::can(Permission::ADMINISTER, 'User') ) {
        $user_options->add(action('UserAdminController@index'), 'Admin Users');
    }

    $name = Auth::check() ? Auth::user()->full_name : 'User';
    Menu::handler('top-menu-right')
      ->add( '#' , $name, $user_options, [], ['class' => "user-links has-dropdown"] );
    
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


    /**
     * @param string $action
     *
     * @return string
     */
    protected function normalizeResourceCrudAction($action)
    {
        // Only analise if the action is not CRUD
        if ( ! in_array($action, Permission::CRUD_ACTIONS)) {
            switch ($action) {
                case 'store':
                    $action = Permission::ACTION_C;
                    break;

                case 'index':
                case 'show':
                    $action = Permission::ACTION_R;
                    break;

                case 'edit':
                    $action = Permission::ACTION_U;
                    break;

                case 'destroy':
                    $action = Permission::ACTION_D;
                    break;

                default:
                    throw new UnexpectedValueException("Action '{$action}' is not recognised in the CRUD scheme.");
            }
        }

        return $action;
    }

}
