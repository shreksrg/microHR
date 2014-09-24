<?php

/**
 * 微信接口模型
 */
class ApiMan_model extends App_model
{
    public function getRow($id)
    {
        $id = (int)$id;
        $sql = "select * from  mhr_story as s1 left join mhr_story_content s2 on s1.id=s2.story_id where s1.isdel=0 and s1.id=$id";
        $query = $this->db->query($sql);
        return $query->row();
    }

    /**
     * 获取列表
     */
    public function getStories($page, $rows = 20, $criteria = null)
    {
        $page = (int)$page;
        if ($page <= 0) $page = 1;
        $start = ($page - 1) * $rows;
        $list = array('total' => 0, 'rows' => array());
        $where = chr(32);
        $order = chr(32);
        $sortArr = array('create_time desc');

        //登记ID
        if (isset($criteria['register_id']) && strlen(($registerId = $criteria['register_id']))) {
            $where .= " and register_id=$registerId";
        }

        //微信ID
        if (isset($criteria['wxid']) && strlen(($wxid = $criteria['wxid']))) {
            $where .= " and wxid=$wxid";
        }

        //故事状态
        if (isset($criteria['status']) && strlen(($status = $criteria['status']))) {
            $now = time();
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


        //鲜花数起始值
        if (isset($criteria['min_flowers']) && strlen(($num = $criteria['min_flowers']))) {
            $where .= " and flowers>=$num";
        }
        //鲜花数终止值
        if (isset($criteria['max_flowers']) && strlen(($num = $criteria['max_flowers']))) {
            $where .= " and flowers<=$num";
        }

        //鸡蛋数起始值
        if (isset($criteria['min_eggs']) && strlen(($num = $criteria['min_eggs']))) {
            $where .= " and eggs>=$num";
        }
        //鸡蛋数终止值
        if (isset($criteria['max_eggs']) && strlen(($num = $criteria['max_eggs']))) {
            $where .= " and eggs<=$num";
        }

        //评分数起始值
        if (isset($criteria['min_grade']) && strlen(($num = $criteria['min_grade']))) {
            $where .= " and grade>=$num";
        }
        //评分数终止值
        if (isset($criteria['max_grade']) && strlen(($num = $criteria['max_grade']))) {
            $where .= " and grade<=$num";
        }

        //排序
        if (isset($criteria['sort']) && strlen(($sort = $criteria['sort']))) {
            $value = str_replace('_', chr(32), $sort);
            array_unshift($sortArr, $value);
        }
        $order .= implode(',', $sortArr);


        $query = $this->db->query("select count(*) as num from mhr_story where isdel=0 $where");
        $total = (int)$query->row()->num;
        if ($total > 0) {
            $query = $this->db->query("select * from mhr_story where isdel=0 $where order by $order limit $start,$rows");
            if ($query->row()) {
                $list['total'] = $total;
                $list['rows'] = $query->result_array();
            }
        }
        return $list;
    }

    /**
     * 新增故事
     */
    public function append($data)
    {
        $return = false;
        $now = time();
        $digest = isset($data['digest']) && strlen($data['digest']) > 0 ? $data['digest'] : mb_substr($data['content'], 32);
        $value = array(
            'register_id' => $data['register_id'],
            'wxid' => $data['wxid'],
            'digest' => $digest,
            'flowers' => (int)$data['flowers'],
            'eggs' => (int)$data['eggs'],
            'grade' => $data['grade'],
            'status' => $data['status'],
            'create_time' => $now,
            'update_time' => $now,
        );

        $reVal = $this->db->insert('mhr_story', $value);
        if ($reVal === true) {
            $newId = $this->db->insert_id();
            $value = array(
                'story_id' => $newId,
                'content' => $data['content'],
            );
            $return = $this->db->insert('mhr_story_content', $value);
        }
        return $return;
    }

    /**
     * 编辑
     */
    public function edit($data)
    {
        $id = (int)$data['id'];
        $value = array(
            'register_id' => $data['register_id'],
            'wxid' => $data['wxid'],
            'digest' => $data['digest'],
            'flowers' => (int)$data['flowers'],
            'eggs' => (int)$data['eggs'],
            'grade' => $data['grade'],
            'status' => $data['status'],
            'update_time' => time(),
        );
        $reVal = $this->db->update('mhr_story', $value, array('id' => $id));
        if ($reVal) {
            $value = array(
                'content' => $data['content'],
                'update_time' => time()
            );
            $reVal = $this->db->update('mhr_story_content', $value, array('story_id' => $id));
        }
        return $reVal;
    }

    /**
     * 删除
     */

    public function drop($id)
    {
        $id = is_array($id) ? implode(',', $id) : (int)$id;
        $sql = "update mhr_story set isdel=1 where isdel=0 and id in($id)";
        $return = $this->db->query($sql);
        if ($return) {
            $sql = "update mhr_story_content set isdel=1 where isdel=0 and story_id in($id)";
            $return = $this->db->query($sql);
        }
        return $return;
    }

    /**
     * 审核
     */
    public function audit($id, $status)
    {
        $id = is_array($id) ? implode(',', $id) : (int)$id;
        $sql = "update mhr_story set status=$status where isdel=0 and id in($id)";
        $return = $this->db->query($sql);
        return $return;
    }

}