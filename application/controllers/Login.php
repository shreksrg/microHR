<?php

class Login extends FrontController
{
    public function index()
    {
        if ($this->_user->isGuest) {
            $modelApi = CModel::make('api_model');
            $reUrl = APP_URL . '/login/auth';
            $reqUrl = $modelApi->authUrl($reUrl);
            CAjax::show(-1, 'fail', $reqUrl);
        } else {
            CAjax::show(0, 'successful');
        }
    }

    public function _authentication()
    {

        return true;
    }

    public function auth()
    {
        $code = $this->input->get('code');
        if ($code) {
            $modelApi = CModel::make('api_model');
            $access = $modelApi->authAccess($code);
            $access = json_decode($access, true);
            if (isset($access['openid'])) {
                $this->user->id = $access['openid'];
                CView::show('auth', array('result' => 'ok'));
            }
        }
        CView::show('auth', array('result' => 'fail'));
    }


}