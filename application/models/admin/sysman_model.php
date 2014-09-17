<?php

/**
 * 筹资项目管理
 */
class SysMan_model extends App_model
{

    public function getUser($id)
    {
        $id = (int)$id;
        $query = $this->db->query("select * from mhr_sys_user where isdel=0 and id=$id limit 1");
        return $query->row_array();
    }

    /**
     * 获取管理员用户列表
     */
    public function getUsers($page, $rows = 20)
    {
        $page = (int)$page;
        if ($page <= 0) $page = 1;
        $start = ($page - 1) * $rows;
        $list = array('total' => 0, 'rows' => array());
        $query = $this->db->query("select count(*) as num from mhr_sys_user where isdel=0");
        $total = (int)$query->row()->num;
        if ($total > 0) {
            $query = $this->db->query("select * from mhr_sys_user where isdel=0  order by create_time desc limit $start,$rows");
            if ($query->row()) {
                $list['total'] = $total;
                $list['rows'] = $query->result_array();
            }
        }
        return $list;
    }


    public function hashPassword($str)
    {
        return md5($str);
    }

    /**
     * 新增管理用户
     */
    public function newUser($data)
    {
        //检查用户名是否重复
        $username = $data['username'];
        $sql = "select id from mhr_sys_user where isdel=0 and username='$username' limit 1";
        $query = $this->db->query($sql, $username);
        if ($query->row()) {
            $this->errCode = 1001;
            return false;
        }

        $now = time();
        $value = array(
            'username' => $data['username'],
            'password' => $this->hashPassword($data['password']),
            'comment' => $data['comment'],
            'status' => $data['status'],
            'create_time' => $now,
            'create_time' => $now,
        );
        $return = $this->db->insert('mhr_sys_user', $value);
        $this->errCode = 1000;
        return $return;
    }


    /**
     * 编辑会员
     */
    public function editUser($data)
    {
        $id = (int)$data['id'];
        $value = array(
            'username' => $data['username'],
            'comment' => $data['comment'],
            'status' => $data['status'],
            'update_time' => time(),
        );
        $reVal = $this->db->update('mhr_sys_user', $value, array('id' => $id));
        return $reVal;
    }

    /**
     * 删除用户
     */
    public function deleteUser($id)
    {
        $id = is_array($id) ? implode(',', $id) : (int)$id;
        $sql = "update mhr_sys_user set isdel=1 where isdel=0 and id in($id)";
        $return = $this->db->query($sql);
        return $return;
    }

    /**
     * 设置管理员密码
     */
    public function setPassword($id, $password)
    {
        if (strlen($password) <= 0) return false;
        $id = (int)$id;
        $password = $this->hashPassword($password);
        $sql = "update mhr_sys_user set password=? where isdel=0 and id=$id";
        $return = $this->db->query($sql, array($password));
        return $return;
    }

}