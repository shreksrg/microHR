<?php

/**
 * 用户登记模型
 */
class Register_model extends App_model
{


    public function genStory($id)
    {
        $sql = "select * from mhr_story where isdel=0 and id=$id";
        $query = $this->db->query($sql);
        new Story($id, $query->row());
    }

    /**
     *
     */
    public function getRows($page, $offset, $args = null)
    {
        if ((int)$page <= 0) $page = 1;
        $start = $page - 1;
        $sql = "SELECT * FROM mhr_story where isdel=0 and isclosed=0 limit $start,$offset";
        $query = $this->db->query($sql);
        if ($query->row()) {
            return $query->result_array();
        }
        return null;
    }


    public function appraise($id, $type)
    {

        $this->db->update('mhr_story', array('type'), array('id' => $id));
    }

    /**
     * 保存登记
     * @param array $data 提交的表单数据
     * @return boolean
     */
    public function save($data)
    {
        $now = time();
        $values = array(
            'wxid' => $data['wxid'],
            'nickname' => $data['nickname'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'academy' => $data['academy'],
            'major' => $data['major'],
            'edu' => $data['edu'],
            'status' => 1,
            'create_time' => $now,
            'update_time' => $now,
        );

        return $this->db->insert('mhr_register', $values);
    }

    public function getRow($args, $sort = null, $limit = null)
    {
        $condition = is_array($args) ? implode('=', $args) : $args;
        if ($sort !== null) $sort = 'order by ' . $sort;
        if ($limit !== null) $limit = 'limit  ' . $limit;
        $sql = "SELECT id FROM mhr_register WHERE isdel=0 and $condition $sort $limit";
        $query = $this->db->query($sql);
        return $query->row();
    }
}

