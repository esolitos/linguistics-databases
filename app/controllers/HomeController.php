<?php

class HomeController extends BaseController
{

    /*
     * Simply redirects to the DoubleObject Database index.
     */
    public function index()
    {
        return Redirect::action('DoubleObjectController@index');
    }


    /**
     * Anyone can view this page.
     *
     * @return bool
     */
    protected function authorityControl()
    {
        return true;
    }
}
