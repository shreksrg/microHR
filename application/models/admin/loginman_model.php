<?php


class LoginMan_model extends CI_Model
{
    private $_uid = 0;
    private $_validateFlag = false;
    protected $_user;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 加密密码
     */
    public function hashPassword($password)
    {
        return md5($password);
    }

    /**
     * 验证用户登录
     */
    public function validate($username, $password)
    {
        $reVal = false;
        $sql = "SELECT id FROM mhr_sys_user WHERE isdel=0 and  username = ? AND password = ? limit 1";
        $query = $this->db->query($sql, array($username, $this->hashPassword($password)));
        if (($row = $query->row())) {
            $this->_uid = $row->id;
            $reVal = true;
        }
        return $reVal;
    }

    public function authenticate($user)
    {
        $this->_user = $user;
        $return = $this->validate($user->username, $user->password);
        return $return;
    }

    /**
     * 保存用户登录信息（生成用户会话）
     */
    public function save()
    {
        $return = false;
        if ($this->_user) {
            $sql = "SELECT * FROM mhr_sys_user WHERE isdel=0 and  id={$this->_uid}";
            $query = $this->db->query($sql);
            if (($row = $query->row())) {
                $this->_user->id = $this->_uid;
                $this->_user->row = $row;
                $return = true;
            }
        }
        return $return;
    }

}