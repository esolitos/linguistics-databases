<?php

class QueryController extends \DoubleObjectController {


  public function getIndex()
  {
    $this->view_data['executed_queries'] = Redis::get('tot_queries');
    
    return $this->makeView('DoubleObject.Query.index');
  }
  
  public function getBuild()
  {
    
    return $this->makeView('DoubleObject.Query.build');
  }

  
  public function postVerify()
  {
    // Verify that the query makes sense!
    
    if ( Input::ajax() ) {
      Response::json( ['key' => 'value'] );
    } else {
      return Redirect::action('QueryController@getIndex');
    }
  }
  
  public function postExecute()
  {
    // Verify that the query makes sense!
    
    Redis::incr('tot_queries');
    return Redirect::action('QueryController@getIndex')->withMessages(['Query executed (I\'m joking!)']);
  }

}