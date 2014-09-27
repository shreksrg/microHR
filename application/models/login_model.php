<?php

class Login_model extends App_model
{
    private $_uid;
    protected $_user;


    /**
     * 申请授权码
     */
    public function applyCode($toPath)
    {
        $modelApi = CModel::make('api_model');
        $reqUrl = $modelApi->authUrl($toPath);
        header('location:' . $reqUrl);
    }

    /**
     * 微信网页授权
     */
    public function webAuth($code)
    {
        $errCode = -1;
        $modelApi = CModel::make('api_model');
        $access = $modelApi->authAccess($code);
        $access = json_decode($access, true);
        if (isset($access['openid'])) {
            $errCode = 0;
            $this->_user->id = $access['openid'];
        } elseif (isset($access['errcode'])) {
            $errCode = $access['errcode'];
        }
        return $errCode;
    }



}