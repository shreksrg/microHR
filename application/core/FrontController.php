<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('APP_URL', SITE_URL);
//define('WEB_PATH', SITE_URL . '/microhr');
define('WEB_PATH', SITE_URL );
//define('APP_URL', SITE_URL . '/microhr/index.php');

class FrontController extends CController
{
    public function __construct()
    {
        parent::__construct();
        $this->_user = new User();
        $this->_init();
    }

    /**
     * 微信网页授权
     */
    protected function _webAuth()
    {
        $modelLogin = CModel::make('login_model');
        $authCode = $this->input->get('code');
        if ($authCode) {
            $errCode = $modelLogin->webAuth($this->_user, $authCode);
            if ($errCode !== 0) {
                CView::show('messaage/error', "微信授权验证失败[ERROR:$errCode]");
            }
        } else {
            $toPath = APP_URL . '/' . $this->uri->uri_string();
            $modelLogin->applyCode($toPath);
        }
    }

    public function _authentication()
    {
        if ($this->_user->isGuest) $this->_webAuth();
    }

}