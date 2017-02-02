<?php

abstract class DoubleObjectBase extends \BaseController
{

    public function __construct()
    {
        parent::__construct();
        $li_attr = [ 'class' => "has-dropdown not-click" ];
        $ul_attr = [ 'class' => "dropdown" ];

        $categoySubmenu = Menu::items(null, $ul_attr);

        if ( Authority::can(Permission::ACTION_C, 'OccurrenceCategory')) {
            $categoySubmenu->add(action('CategoryController@create'), 'New Category');
        }

        $propertySubmenu = Menu::items(null, $ul_attr);

        if ( Authority::can(Permission::ACTION_C, 'ObjectProperty')) {
            $propertySubmenu->add(action('ObjectPropertyController@create'), 'New Property');
        }

        $occurrenceSubmenu = Menu::items(null, $ul_attr);
        if ( Authority::can(Permission::ACTION_C, 'Occurrence')) {
            $occurrenceSubmenu->add(action('OccurrenceController@create'), 'New Occurrence');
        }

        if ( Authority::can(Permission::ACTION_R, 'Occurrence')) {
            $occurrenceSubmenu->add(action('OccurrenceController@index'), 'All Occurrences');
            $occurrenceSubmenu->add(action('OccurrenceController@verbs'), 'All Verbs');
        }

        $main_menu = Menu::handler('top-menu-left')->add(action('DoubleObjectController@index'), 'DoubleObject DB');

        if ( Authority::can(Permission::ACTION_R, 'OccurrenceCategory')) {
            $main_menu->add(action('CategoryController@index'), 'Categories', $categoySubmenu, [], $li_attr);
        }

        if ( Authority::can(Permission::ACTION_R, 'ObjectProperty')) {
            $main_menu->add(action('ObjectPropertyController@index'), 'Object Properties', $propertySubmenu, [], $li_attr);
        }

        if ( Authority::can(Permission::ACTION_R, 'Occurrence')) {
            $main_menu->add(action('OccurrenceController@index'), 'Occurrences', $occurrenceSubmenu, [], $li_attr);
        }


        if ( Authority::can(Permission::ACTION_R, 'Queries')) {
            $querySubmenu = Menu::items(null, $ul_attr)
                ->add(action('QueryController@anyPropertyDistribution'), 'Property Distribution');

            Menu::handler('top-menu-right')
                ->add(action('QueryController@getIndex'), 'Query DB', $querySubmenu, [], $li_attr)
                ->add(action('StatisticsController@getIndex'), 'Statistics', null, [], []);
        }

    }

}