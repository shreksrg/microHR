<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('APP_URL', SITE_URL);
//define('APP_URL', SITE_URL . '/microhr/index.php');

class FrontController extends CController
{
    public function __construct()
    {
        parent::__construct();
        $this->_user = new User();
        $this->_init();
    }

    public function _authentication()
    {
        if ($this->_user->isGuest) {
            $authCode = $this->input->get('code');
            $modelApi = CModel::make('api_model');
            if ($authCode) {
                $access = $modelApi->authAccess($authCode);
                $access = json_decode($access, true);
                if (isset($access['openid'])) {
                    $this->user->id = $access['openid'];
                    return true;
                } else {
                    $errCode = isset($access['errcode']) ? $access['errcode'] : 1000;
                    CView::show('message/error', array('code' => $errCode, 'content' => '授权登录失败'));
                }
            } else {
                $modelApi = CModel::make('api_model');
                $reUrl = APP_URL . '/' . $this->uri->uri_string();
                $reqUrl = $modelApi->authUrl($reUrl);
                CView::show('auth', array('reqUrl' => $reqUrl));
                exit;
            }
        }
    }

}