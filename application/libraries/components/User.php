<?php

class User extends CUser
{
    public $username;
    public $password;

    protected $_keyRow = '__userRow';

    public function getRow()
    {
        return $this->getState($this->_keyRow);
    }

    public function setRow($data)
    {
        $this->setState($this->_keyRow, $data);
    }

    public function logout()
    {
        $this->clearStates();
    }

}