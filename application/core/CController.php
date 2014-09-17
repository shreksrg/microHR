<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CController extends CI_Controller
{
    protected $_user;

    public function __construct()
    {
        parent::__construct();
        defined('REQUEST_METHOD') or define('REQUEST_METHOD', $this->input->server('REQUEST_METHOD'));
        micro::openSession();

    }

    protected function _init()
    {
        if (method_exists($this, '_authentication')) {
            call_user_func_array(array($this, '_authentication'), array());
        }
    }
}