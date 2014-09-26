<?php

class Login_model extends App_model
{
    private $_uid;
    protected $_user;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 申请微信授权登录
     * @param USER $user 用户对象
     * @return boolean
     */
    public function authLogin($user, $reUrl = null)
    {
        //申请授权码
        $modelApi = CModel::make('api_model');
        $action = $modelApi->authUrl($reUrl);
        CView::show('code', array('action' => $action));
    }

}