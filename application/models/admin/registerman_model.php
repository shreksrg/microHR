<?php

/**
 * 登记者模型
 */
class RegisterMan_model extends App_model
{

    public function getRow($id)
    {
        $id = (int)$id;
        $query = $this->db->query("select * from mhr_register where isdel=0 and id=$id");
        return $query->row();
    }

    /**
     * 获取列表
     */
    public function getRegistrant($page, $rows = 20, $criteria = null)
    {
        $page = (int)$page;
        if ($page <= 0) $page = 1;
        $start = ($page - 1) * $rows;
        $list = array('total' => 0, 'rows' => array());
        $where = chr(32);
        $order = chr(32);
        $sortArr = array('create_time desc');


        //昵称
        if (isset($criteria['nickname']) && strlen(($nickname = $criteria['nickname']))) {
            $where .= " and locate('$nickname',nickname)>0";
        }

        //微信ID
        if (isset($criteria['wxid']) && strlen(($wxid = $criteria['wxid']))) {
            $where .= " and wxid=$wxid";
        }

        //性别
        if (isset($criteria['gender']) && strlen(($gender = $criteria['gender']))) {
            $where .= " and gender=$gender";
        }

        //手机
        if (isset($criteria['mobile']) && strlen(($mobile = $criteria['mobile']))) {
            $where .= " and locate('$mobile',mobile)>0";
        }

        //状态
        if (isset($criteria['status']) && strlen(($status = $criteria['status']))) {
            $where .= " and status=$status";
        }

        //创建起始日期
        if (isset($criteria['ab_time']) && strlen(($abTime = $criteria['ab_time']))) {
            $abTime = strtotime($abTime);
            $where .= " and create_time>=$abTime";
        }

        //创建截止日期
        if (isset($criteria['ae_time']) && strlen(($aeTime = $criteria['ae_time']))) {
            $aeTime = strtotime($aeTime);
            $where .= " and create_time<=$aeTime";
        }

        //学院
        if (isset($criteria['academy']) && strlen(($academy = $criteria['academy']))) {
            $where .= " and locate('$academy',academy)>0";
        }

        //专业
        if (isset($criteria['major']) && strlen(($major = $criteria['major']))) {
            $where .= " and locate('$major',major)>0";
        }

        $order .= implode(',', $sortArr);

        $query = $this->db->query("select count(*) as num from mhr_register where isdel=0 $where");
        $total = (int)$query->row()->num;
        if ($total > 0) {
            $query = $this->db->query("select * from mhr_register where isdel=0 $where  order by $order  limit $start,$rows");
            if ($query->row()) {
                $list['total'] = $total;
                $list['rows'] = $query->result_array();
            }
        }
        return $list;
    }

    /**
     * 新增注册
     */
    public function append($data)
    {
        $newId = 0;
        $value = array(
            'nickname' => $data['nickname'],
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
            'academy' => $data['academy'],
            'major' => $data['major'],
            'wxid' => $data['wxid'],
            'status' => $data['status'],
            'comment' => $data['comment'],
            'create_time' => time(),
            'update_time' => time(),
        );

        $reVal = $this->db->insert('mhr_register', $value);
        if ($reVal === true) {
            $newId = $this->db->insert_id();
        }
        return $newId;
    }

    /**
     * 编辑商品
     */
    public function edit($data)
    {
        $id = (int)$data['id'];
        $value = array(
            'nickname' => $data['nickname'],
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
            'academy' => $data['academy'],
            'major' => $data['major'],
            'wxid' => $data['wxid'],
            'status' => $data['status'],
            'comment' => $data['comment'],
            'update_time' => time(),
        );
        $reVal = $this->db->update('mhr_register', $data, array('id' => $id));
        return $reVal;
    }

    /**
     * 删除
     */
    public function drop($id)
    {
        $id = is_array($id) ? implode(',', $id) : (int)$id;
        $sql = "update mhr_register set isdel=1 where isdel=0 and id in($id)";
        $return = $this->db->query($sql);
        return $return;
    }

}