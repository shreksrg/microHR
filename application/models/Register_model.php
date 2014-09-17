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
     */
    public function save($data)
    {
        $gender = $data['gender'];
        $mobile = $data['mobile'];
        $academy = $data['academy'];
        $ma = $data['mobile'];
        $value = array(
            'gender' => $data['gender'],
            'mobile' => $mobile,
            'academy' => $gender,
        );
        return $this->db->insert('mhr_register', $value);
    }
}

