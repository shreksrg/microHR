<?php

class App_model extends CI_Model
{
    protected $_errCode = 0;
    protected $_errCodes = array();

    public function setErrCode($code)
    {
        $this->_errCode = $code;
    }

    public function getErrCode()
    {
        return $this->_errCode;
    }
}