<?php

class StatisticsController extends \DoubleObjectController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
    $objects['DIR'] = array_flatten( CategoryObject::where('type', '=', 'DIR')->lists('id') );
    $objects['IND'] = array_flatten( CategoryObject::where('type', '=', 'IND')->lists('id') );
    
    $this->view_data['categories'] = (object) [
      'tot' => OccurrenceCategory::count(),
      'double_object' => (object) [
        'tot' => OccurrenceCategory::whereNotNull('second_object_id')->count(),
        'direct_first' => OccurrenceCategory::whereNotNull('second_object_id')->whereIn('first_object_id', $objects['DIR'])->lists('id'), 
        'indirect_first' => OccurrenceCategory::whereNotNull('second_object_id')->whereIn('first_object_id', $objects['IND'])->lists('id'), 
      ],
      'single_object' => (object) [
        'tot' => OccurrenceCategory::whereNull('second_object_id')->count(),
        'direct' => OccurrenceCategory::whereNull('second_object_id')->whereIn('first_object_id', $objects['DIR'])->count(),
        'indirect' => OccurrenceCategory::whereNull('second_object_id')->whereIn('first_object_id', $objects['IND'])->count(),
      ],
      'object_types' => CategoryObject::count(),
    ];
    
    
    $occurr_per['cat'] = Occurrence::selectRaw('COUNT(*) as `tot`, `category_id` as `cat`')->groupBy('cat')->orderBy('cat')->remember(1)->get(['tot', 'cat']);
    $occurr_per['verb'] = Occurrence::selectRaw('COUNT(*) as `tot`, `verb`')->groupBy('verb')->orderBy('verb')->remember(1)->get(['tot', 'verb']);
    $occurr_per['keyword'] = Occurrence::selectRaw('COUNT(*) as `tot`, `keyword`')->groupBy('keyword')->orderBy('keyword')->remember(1)->get(['tot', 'keyword']);
    // dd( $occurr_per_cat );
    
    $this->view_data['occurrences'] = (object) [
      'tot' => Occurrence::count(),
      'per_category'  => array_combine( $occurr_per['cat']->lists('cat') , $occurr_per['cat']->lists('tot')),
      'per_verb'  => array_combine( $occurr_per['verb']->lists('verb') , $occurr_per['verb']->lists('tot')),
      'per_keyword'  => array_combine( $occurr_per['keyword']->lists('keyword') , $occurr_per['keyword']->lists('tot')),
    ];
    
    $props['IND'] = OccurrenceObjectProperty::selectRaw('COUNT(*) as `tot`, `property_id` as `pid`')->where('type', '=', 'IND')->groupBy('pid')->remember(1)->get();
    $props['DIR'] = OccurrenceObjectProperty::selectRaw('COUNT(*) as `tot`, `property_id` as `pid`')->where('type', '=', 'DIR')->groupBy('pid')->remember(1)->get();
  
    $prop_names = ObjectProperty::remember(1)->orderBy('name')->get();
    
    $this->view_data['properties'] = (object) [
      'tot' => ObjectProperty::count(),
      'usage' => (object) [
        'direct' => array_combine( $props['DIR']->lists('pid'), $props['DIR']->lists('tot') ),
        'indirect' => array_combine( $props['IND']->lists('pid'), $props['IND']->lists('tot') ),
      ],
      'names' => array_combine( $prop_names->lists('id'), $prop_names->lists('name') )
    ];
    
    arsort($this->view_data['properties']->usage->direct);
    arsort($this->view_data['properties']->usage->indirect);
    
    unset($objects);
    unset($occurr_per);
    unset($props);
    
    return $this->makeView('DoubleObject.Statistics.index');
	}

}