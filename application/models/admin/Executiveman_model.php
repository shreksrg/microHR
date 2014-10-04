<?php

/**
 * 高管模型
 */
class ExecutiveMan_model extends App_model
{
    public function getRow($id)
    {
        $id = (int)$id;
        $sql = "select id,name,avatar,title,content,favorites from  mhr_executive  where isdel=0 and id=$id";
        $query = $this->db->query($sql);
        return $query->row();
    }

    /**
     * 获取列表
     */
    public function getRows($page, $rows = 20, $criteria = null)
    {
        $page = (int)$page;
        if ($page <= 0) $page = 1;
        $start = ($page - 1) * $rows;
        $list = array('total' => 0, 'rows' => array());
        $where = chr(32);
        $order = chr(32);
        $sortArr = array('create_time desc');

        //高管名
        if (isset($criteria['name']) && strlen(($name = $criteria['name']))) {
            $where .= " and name=$name";
        }

        //职位
        if (isset($criteria['title']) && strlen(($title = $criteria['title']))) {
            $where .= " and title=$title";
        }

        //发布状态
        if (isset($criteria['status']) && strlen(($status = $criteria['status']))) {
            $now = time();
            $where .= " and status=$status";
        }

        //创建起始日期
        if (isset($criteria['ab_time']) && strlen(($abTime = $criteria['ab_time']))) {
            $abTime = strtotime($abTime);
            $where .= " and create_time>=$abTime";
        }


        //点赞数起始值
        if (isset($criteria['min_favorites']) && strlen(($num = $criteria['min_favorites']))) {
            $where .= " and favorites>=$num";
        }
        //点赞数终止值
        if (isset($criteria['max_favorites']) && strlen(($num = $criteria['max_favorites']))) {
            $where .= " and favorites<=$num";
        }


        //排序
        if (isset($criteria['sort']) && strlen(($sort = $criteria['sort']))) {
            $value = str_replace('_', chr(32), $sort);
            array_unshift($sortArr, $value);
        }
        $order .= implode(',', $sortArr);


        $query = $this->db->query("select count(*) as num from mhr_executive where isdel=0 $where");
        $total = (int)$query->row()->num;
        if ($total > 0) {
            $query = $this->db->query("select id,name,avatar,title,digest,favorites from mhr_executive where isdel=0 $where order by $order limit $start,$rows");
            if ($query->row()) {
                $list['total'] = $total;
                $list['rows'] = $query->result_array();
            }
        }
        return $list;
    }

    /**
     * 新增高管
     */
    public function append($data)
    {
        $return = false;
        $now = time();
        $digest = isset($data['digest']) && strlen($data['digest']) > 0 ? $data['digest'] : mb_substr($data['content'], 32);
        $value = array(
            'name' => $data['name'],
            'avatar' => $data['avatar'],
            'digest' => $digest,
            'favorites' => $data['favorites'],
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'],
            'sort' => $data['sort'],
            'create_time' => $now,
            'update_time' => $now,
        );

        $reVal = $this->db->insert('mhr_executive', $value);
        return $reVal;
    }

    /**
     * 编辑
     */
    public function edit($data)
    {
        $value = array(
            'name' => $data['name'],
            'avatar' => $data['avatar'],
            'digest' => $data['digest'],
            'favorites' => $data['favorites'],
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => $data['status'],
            'sort' => $data['sort'],
            'update_time' => time(),
        );
        $reVal = $this->db->update('mhr_executive', $value, array('id' => $data['id']));
        return $reVal;
    }

    /**
     * 删除
     */
    public function drop($id)
    {
        $id = is_array($id) ? implode(',', $id) : (int)$id;
        $sql = "update mhr_executive set isdel=1 where isdel=0 and id in($id)";
        $return = $this->db->query($sql);
        return $return;
    }

    /**
     * 审核
     */
    public function audit($id, $status)
    {
        $id = is_array($id) ? implode(',', $id) : (int)$id;
        $sql = "update mhr_executive set status=$status where isdel=0 and id in($id)";
        $return = $this->db->query($sql);
        return $return;
    }

}