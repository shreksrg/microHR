<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('APP_URL', SITE_URL);

class FrontController extends CController
{
    /**
     * @var session键前缀
     */
    protected $_session_prefix_key = '';

    public function __construct()
    {
        parent::__construct();
        $this->_user = new User();
        $this->_init();
        $this->_session_prefix_key = base64_encode('_microHR_session');
    }

    public function _authentication()
    {
        if ($this->_user->isGuest) {
            $modelLogin = CModel::make('login_model');
            $return = $modelLogin->authLogin($this->_user); //申请授权并登录
            if ($return !== true) {
                CAjax::result($return);
                exit(0);
            }
        }
    }

    public function setSession($key, $data)
    {
        $key = $this->_session_prefix_key . $key;
        $_SESSION[$key] = $data;
    }

    public function getSession($key = null)
    {
        $key = $this->_session_prefix_key . $key;
        return isset($_SESSION[$key]) ? ($session = & $_SESSION[$key]) : null;
    }
}