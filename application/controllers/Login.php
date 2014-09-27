<?php

class Login extends FrontController
{

    public function _authentication()
    {
        return true;
    }

    /**
     * 登录验证
     */
    public function index()
    {
        $toPath = $this->input->get('reUrl');
        if ($this->_user->isGuest) {
            $modelApi = CModel::make('api_model');
            $reqUrl = $modelApi->authUrl($toPath);
            header('location:' . $reqUrl);
        } else {
            header('location:' . $toPath);
        }
    }

    public function check()
    {
        $action = $this->input->get('action');
        if ($action == 'ajax') {
            $return = $this->_user->isGuest !== true;
            CAjax::result($return);
            exit;
        }
    }

}