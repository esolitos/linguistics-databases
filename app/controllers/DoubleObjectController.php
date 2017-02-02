<?php

class DoubleObjectController extends \DoubleObjectBase
{
    public function index()
    {
        return $this->makeView('DoubleObject/index');
    }

    /**
     * Checks if the user has access to this class.
     *
     * @return bool
     */
    protected function authorityControl()
    {
        return Auth::check();
    }
}