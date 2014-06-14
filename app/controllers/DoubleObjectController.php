<?php

class DoubleObjectController extends \BaseController {

  public function __construct()
  {
    parent::__construct();
    $li_attr = ['class' => "has-dropdown not-click"];
    $ul_attr = ['class' => "dropdown"];
    
    Menu::handler('top-menu-left')
      ->add( action('DoubleObjectController@index') , 'DoubleObject DB')
      ->add( action('CategoryController@index') , 'Categories',  Menu::items(null, $ul_attr)->add( action('CategoryController@create') , 'New Category'), [], $li_attr)
      ->add( action('ObjectPropertyController@index') , 'Object Properties', Menu::items(null, $ul_attr)->add( action('ObjectPropertyController@create') , 'New Property'), [], $li_attr)
      ->add( action('OccurrenceController@index') , 'Occurrence', Menu::items(null, $ul_attr)->add( action('OccurrenceController@create') , 'New Occurrence'), [], $li_attr );

    Menu::handler('top-menu-right')
      ->add( action('QueryController@getIndex') , 'Query DB', null, [], [] )
      ->add( action('StatisticsController@getIndex') , 'Statistics', null, [], [] );

  }

  public function index()
  {
    return $this->makeView('DoubleObject/index');
  }

}