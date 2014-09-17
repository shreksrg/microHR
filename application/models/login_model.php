<?php


class Login_model extends CI_Model
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
    public function authLogin($user)
    {
        //申请授权码
        $authCode = $this->applyAuth();
        if ($authCode) {
            $access = $this->getAccess($authCode);
            if ($access) {
                $user->id = $access['openID'];
                $user->row = $access;
                return true;
            }
        }
        return false;
    }

    /**
     * 申请微信授权码
     */
    public function applyAuth()
    {
        return $code = 'CODE=ABC123456';
    }


    /**
     * 获取用户微信授权访问信息
     * @param string 授权码
     * @return int
     */
    public function getAccess($code)
    {
        return $access = array('openID' => 'openID=ABCD123456');
    }


}