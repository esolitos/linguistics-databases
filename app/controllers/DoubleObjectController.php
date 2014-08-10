<?php

class DoubleObjectController extends \BaseController {

  public function __construct()
  {
    parent::__construct();
    $li_attr = ['class' => "has-dropdown not-click"];
    $ul_attr = ['class' => "dropdown"];
    
    $categoySubmenu = Menu::items(null, $ul_attr)
      ->add( action('CategoryController@create') , 'New Category');
    
    $propertySubmenu = Menu::items(null, $ul_attr)
      ->add( action('ObjectPropertyController@create'), 'New Property');
    
    $occurrenceSubmenu = Menu::items(null, $ul_attr)
      ->add( action('OccurrenceController@create'), 'New Occurrence')
      ->add( action('OccurrenceController@index'), 'All Occurrences')
      ->add( action('OccurrenceController@verbs'), 'All Verbs');
    
    Menu::handler('top-menu-left')
      ->add( action('DoubleObjectController@index') , 'DoubleObject DB')
      ->add( action('CategoryController@index') , 'Categories', $categoySubmenu, [], $li_attr)
      ->add( action('ObjectPropertyController@index') , 'Object Properties', $propertySubmenu, [], $li_attr)
      ->add( action('OccurrenceController@index') , 'Occurrence', $occurrenceSubmenu, [], $li_attr );

    Menu::handler('top-menu-right')
      ->add( action('QueryController@getIndex') , 'Query DB', null, [], [] )
      ->add( action('StatisticsController@getIndex') , 'Statistics', null, [], [] );

  }

  public function index()
  {
    return $this->makeView('DoubleObject/index');
  }

}