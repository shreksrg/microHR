<?php

class Story extends CAppComponent
{
    protected $_id = 0;
    protected $_row = null;
    public static $_stories = array();

    public function __construct($id, $row = null)
    {
        $this->_id = $id;
        $this->_row = $row;
    }

    public function setRow($row)
    {
        $this->_row = $row;
    }
    
    public function getRow()
    {
        return $this->_row;
    }


}