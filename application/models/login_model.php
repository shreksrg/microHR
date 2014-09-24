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

    /**
     * 申请微信授权码
     */
    public function applyAuth()
    {
        $code = null;
        return $code = 'CODE=ABC123456';
    }


    /**
     * 获取用户微信授权访问信息
     * @param string 授权码
     * @return int
     */
    public function getAccess($code)
    {
        $access = array();
        return $access = array('openID' => 'openID=ABCD123456');
    }

    public function getOpenID()
    {
        //申请授权码
        $openID = false;
        $authCode = $this->applyAuth();
        if ($authCode) {
            $access = $this->getAccess($authCode);
            if ($access) $openID = $access['openID'];
        }
        return $openID;
    }
}