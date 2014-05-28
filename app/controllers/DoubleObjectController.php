<?php

class DoubleObjectController extends \BaseController {

  public function __construct()
  {
    parent::__construct();
    
    Menu::handler('top-menu-left')
      ->add('index', 'Double Object DB');
  }

  public function index()
  {
    return View::make('DoubleObject/index', $this->view_data);
  }

}