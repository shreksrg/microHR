<?php

/**
 * 高管模型
 */
class Executive_model extends App_model
{

    /**
     *
     */
    public function getRows($start, $offset, $args = null)
    {
        $sql = "SELECT id,name,title,digest,avatar,favorites,create_time FROM mhr_executive where isdel=0 and status=1 order by create_time desc limit $start,$offset";
        $query = $this->db->query($sql);
        if ($query->row()) {
            return $query->result_array();
        }
        return null;
    }


    public function getRow($id)
    {
        $sql = "SELECT id,name,title,digest,avatar,favorites,content FROM mhr_executive where isdel=0 and status=1 and id=$id  limit 1";
        $query = $this->db->query($sql);
        if ($query->row()) {
            return $query->row_array();
        }
        return null;
    }

    public function getLog($openId, $manId, $type = 1)
    {
        $sql = "SELECT * FROM mhr_executive_log where isdel=0 and wxid='$openId' and man_id=$manId and type=1  limit 1";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function addLog($openId, $manId, $type = 1)
    {
        $value = array(
            'wxid' => $openId,
            'man_id' => $manId,
            'type' => $type,
            'create_time' => time(),
        );
        $return = $this->db->insert('mhr_executive_log', $value);
        return $return;
    }

    /**
     * 高管点赞
     */
    public function appraise($id)
    {
        $now = time();
        $sql = "update mhr_executive set favorites=favorites+1,update_time=$now where isdel=0 and status=1 and id=$id";
        $return = $this->db->query($sql);
        return $return;
    }
}

