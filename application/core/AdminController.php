<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('APP_URL', SITE_URL . '/admin');
define('MCIRO_PANEL_TITLE', '海亮微信招聘管理平台V1.0');

class AdminController extends CController
{
    protected $_user;

    public function __construct()
    {
        parent::__construct();
        $this->_user = new User();
        $this->_user->stateKeyPrefix = base64_encode('_microHR_adminKey');
        $this->_init();
    }

    protected function _authentication()
    {
        if ($this->_user->isGuest) {
            header('location:' . SITE_URL . '/admin/loginman');
            die(0);
        }
    }
}