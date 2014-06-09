<?php

class QueryController extends \DoubleObjectController {


  public function getIndex()
  {
    $this->view_data['executed_queries'] = Redis::get('tot_queries');
    
    return View::make('DoubleObject.Query.index', $this->view_data);
  }
  
  public function getBuild()
  {
    
    return View::make('DoubleObject.Query.build', $this->view_data);
  }

  
  public function postVerify()
  {
    
    return View::make('DoubleObject.Query.build', $this->view_data);
  }

}